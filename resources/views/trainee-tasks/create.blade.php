@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-plus-circle text-green-500 mr-3"></i>
                    Buat Task Baru
                </h1>
                <p class="text-gray-600 mt-2">Isi detail untuk membuat task baru</p>
            </div>
            <a href="{{ route('trainee-tasks.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Task
            </a>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Informasi Task</h2>
                    <p class="text-green-100 text-sm">Masukkan detail task di bawah ini</p>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-8">
            <form id="createTaskForm" class="space-y-8">
                @csrf
                
                <!-- Trainee Selection -->
                <div class="space-y-2">
                    <label for="trainee_id" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user text-gray-400 mr-2"></i>
                        Nama Trainee <span class="text-red-500">*</span>
                    </label>
                    <select class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200" 
                            id="trainee_id" name="trainee_id" 
                            @if(!Auth::guard('admin')->check()) disabled @endif required>
                        @if(Auth::guard('admin')->check())
                            <option value="">Pilih Trainee</option>
                            @foreach($trainees as $trainee)
                                <option value="{{ $trainee->id }}">{{ $trainee->name }}</option>
                            @endforeach
                        @else
                            <option value="{{ Auth::id() }}" selected>{{ Auth::user()->name }}</option>
                            <input type="hidden" name="trainee_id" value="{{ Auth::id() }}">
                        @endif
                    </select>
                    <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                </div>

                <!-- Task Title -->
                <div class="space-y-2">
                    <label for="task" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-tasks text-gray-400 mr-2"></i>
                        Judul Tugas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200" 
                           id="task" name="task" required placeholder="Masukkan judul tugas">
                    <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                </div>

                <!-- Task Description -->
                <div class="space-y-2">
                    <label for="desc" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-align-left text-gray-400 mr-2"></i>
                        Deskripsi Tugas <span class="text-red-500">*</span>
                    </label>
                    <textarea class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 resize-none" 
                              id="desc" name="desc" rows="4" required placeholder="Jelaskan detail tugas yang harus dikerjakan..."></textarea>
                    <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                    <p class="text-xs text-gray-500">Berikan deskripsi yang jelas dan detail tentang tugas</p>
                </div>

                <!-- Date Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div class="space-y-2">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-plus text-gray-400 mr-2"></i>
                            Tanggal Mulai Pengerjaan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 datetime-picker" 
                                   id="start_date" name="start_date" required readonly placeholder="Pilih tanggal mulai">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                    </div>

                    <!-- Deadline -->
                    <div class="space-y-2">
                        <label for="deadline" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-times text-gray-400 mr-2"></i>
                            Tanggal Batas Waktu <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 datetime-picker" 
                                   id="deadline" name="deadline" required readonly placeholder="Pilih tanggal batas waktu">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                    </div>
                </div>

                <!-- Helper Text -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Tips untuk membuat task:</h3>
                            <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                                <li>Berikan judul yang jelas dan spesifik</li>
                                <li>Tuliskan deskripsi yang detail dan mudah dipahami</li>
                                <li>Pastikan batas waktu realistis dan dapat dicapai</li>
                                <li>Periksa kembali semua informasi sebelum menyimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="button" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200 transform hover:scale-105" 
                            id="cancelBtn">
                        <i class="fas fa-times mr-2"></i>
                        Batal & Reset
                    </button>
                    <button type="submit" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 transform hover:scale-105 shadow-lg" 
                            id="submitBtn">
                        <i class="fas fa-check mr-2"></i>
                        Buat Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    initializeDatePickers();
    setupFormHandlers();
    setupFormValidation();
});

function initializeDatePickers() {
    $('.datetime-picker').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        locale: {
            firstDayOfWeek: 1,
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            },
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            }
        },
        onOpen: function(selectedDates, dateStr, instance) {
            instance.element.classList.add('ring-2', 'ring-green-500', 'border-green-500');
        },
        onClose: function(selectedDates, dateStr, instance) {
            instance.element.classList.remove('ring-2', 'ring-green-500', 'border-green-500');
            
            // Validate dates when both are selected
            if ($('#start_date').val() && $('#deadline').val()) {
                validateDateRange();
            }
        }
    });
}

function setupFormHandlers() {
    // Cancel button - reset form with confirmation
    $('#cancelBtn').on('click', function() {
        let hasData = false;
        $('#createTaskForm input, #createTaskForm textarea, #createTaskForm select').each(function() {
            if ($(this).attr('type') === 'hidden' || $(this).prop('disabled')) {
                return true;
            }
            
            if ($(this).val() && $(this).val() !== '') {
                hasData = true;
                return false;
            }
        });

        if (hasData) {
            Swal.fire({
                title: 'Konfirmasi Reset',
                text: 'Apakah Anda yakin ingin mengosongkan semua field? Data yang sudah diisi akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded mr-3',
                    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    resetForm();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Form berhasil direset',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        } else {
            resetForm();
        }
    });

    // Form submission
    $('#createTaskForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: 'Apakah Anda yakin ingin menyimpan task ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded mr-3',
                cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm();
            }
        });
    });
}

function setupFormValidation() {
    // Real-time validation
    $('#createTaskForm [required]').on('blur', function() {
        validateField($(this));
    });

    // Task title validation
    $('#task').on('input', function() {
        let value = $(this).val();
        if (value.length > 100) {
            showFieldError($(this), 'Judul tugas maksimal 100 karakter');
        } else {
            hideFieldError($(this));
        }
    });

    // Description validation
    $('#desc').on('input', function() {
        let value = $(this).val();
        if (value.length > 500) {
            showFieldError($(this), 'Deskripsi maksimal 500 karakter');
        } else {
            hideFieldError($(this));
        }
    });
}

function validateField(field) {
    if (!field.val() || field.val().trim() === '') {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    } else {
        hideFieldError(field);
        return true;
    }
}

function showFieldError(field, message) {
    field.removeClass('border-gray-300').addClass('border-red-500');
    field.siblings('.invalid-feedback').removeClass('hidden').text(message);
}

function hideFieldError(field) {
    field.removeClass('border-red-500').addClass('border-gray-300');
    field.siblings('.invalid-feedback').addClass('hidden').empty();
}

function validateDateRange() {
    let startDate = new Date($('#start_date').val());
    let deadline = new Date($('#deadline').val());
    
    if (deadline <= startDate) {
        showFieldError($('#deadline'), 'Tanggal batas waktu harus setelah tanggal mulai');
        return false;
    } else {
        hideFieldError($('#deadline'));
        return true;
    }
}

function validateForm() {
    let isValid = true;
    
    // Clear previous errors
    $('.border-red-500').removeClass('border-red-500').addClass('border-gray-300');
    $('.invalid-feedback').addClass('hidden').empty();
    
    // Validate required fields
    $('#createTaskForm [required]').each(function() {
        if (!validateField($(this))) {
            isValid = false;
        }
    });
    
    // Validate date range
    if ($('#start_date').val() && $('#deadline').val()) {
        if (!validateDateRange()) {
            isValid = false;
        }
    }
    
    if (!isValid) {
        Swal.fire({
            title: 'Form Tidak Valid',
            text: 'Mohon lengkapi dan perbaiki semua field yang bermasalah',
            icon: 'error',
            confirmButtonText: 'Mengerti'
        });
        
        // Scroll to first error
        let firstError = $('.border-red-500').first();
        if (firstError.length) {
            $('html, body').animate({
                scrollTop: firstError.offset().top - 100
            }, 500);
        }
    }
    
    return isValid;
}

function resetForm() {
    $('#createTaskForm')[0].reset();
    $('.border-red-500').removeClass('border-red-500').addClass('border-gray-300');
    $('.invalid-feedback').addClass('hidden').empty();
    
    // Reset flatpickr
    $('.datetime-picker').each(function() {
        if (this._flatpickr) {
            this._flatpickr.clear();
        }
    });
    
    @if(Auth::guard('admin')->check())
        $('#trainee_id').val('');
    @endif
}

function submitForm() {
    // Disable buttons during submission
    $('#submitBtn, #cancelBtn').prop('disabled', true);
    $('#submitBtn').html('<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...');
    
    // Show loading overlay
    Swal.fire({
        title: 'Menyimpan Data',
        text: 'Mohon tunggu, sedang memproses...',
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    let formData = new FormData($('#createTaskForm')[0]);

    $.ajax({
        url: '{{ route("trainee-tasks.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.close();
            
            if (response.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message || 'Task berhasil dibuat',
                    icon: 'success',
                    confirmButtonText: 'Mengerti'
                }).then(() => {
                    window.location.href = '{{ route("trainee-tasks.index") }}';
                });
            } else {
                enableButtons();
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        },
        error: function(xhr) {
            Swal.close();
            
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                displayValidationErrors(errors);
                Swal.fire({
                    title: 'Kesalahan Validasi',
                    text: 'Terdapat kesalahan pada input form',
                    icon: 'error',
                    confirmButtonText: 'Mengerti'
                });
            } else {
                let message = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data';
                Swal.fire('Error', message, 'error');
            }
            
            enableButtons();
        }
    });
}

function enableButtons() {
    $('#submitBtn, #cancelBtn').prop('disabled', false);
    $('#submitBtn').html('<i class="fas fa-check mr-2"></i> Buat Task');
}

function displayValidationErrors(errors) {
    $.each(errors, function(field, messages) {
        let input = $(`[name="${field}"]`);
        showFieldError(input, messages[0]);
    });
    
    // Scroll to first error
    let firstError = $('.border-red-500').first();
    if (firstError.length) {
        $('html, body').animate({
            scrollTop: firstError.offset().top - 100
        }, 500);
    }
}
</script>
@endsection