@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-edit text-blue-500 mr-3"></i>
                    Edit Task
                </h1>
                <p class="text-gray-600 mt-2">Update task details below</p>
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
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-tasks text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Informasi Task</h2>
                    <p class="text-blue-100 text-sm">Perbarui detail task di bawah ini</p>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-8">
            <form id="editTaskForm" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Trainee Information (Read Only) -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-gray-500 mr-2"></i>
                        Informasi Trainee
                    </h3>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-lg font-bold text-blue-800">{{ strtoupper(substr($task->trainee->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-900">{{ $task->trainee->name }}</p>
                            <p class="text-sm text-gray-600">{{ $task->trainee->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Task Title -->
                <div class="space-y-2">
                    <label for="task" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-tasks text-gray-400 mr-2"></i>
                        Judul Tugas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                           id="task" name="task" 
                           value="{{ $task->task }}" 
                           required placeholder="Masukkan judul tugas">
                    <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                </div>

                <!-- Task Description -->
                <div class="space-y-2">
                    <label for="desc" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-align-left text-gray-400 mr-2"></i>
                        Deskripsi Tugas <span class="text-red-500">*</span>
                    </label>
                    <textarea class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none" 
                              id="desc" name="desc" rows="4" required placeholder="Jelaskan detail tugas yang harus dikerjakan...">{{ $task->desc }}</textarea>
                    <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                    <p class="text-xs text-gray-500">Berikan deskripsi yang jelas dan detail tentang tugas</p>
                </div>

                <!-- Date Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div class="space-y-2">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-plus text-gray-400 mr-2"></i>
                            Tanggal Start Pengerjaan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 datetime-picker" 
                                   id="start_date" name="start_date" 
                                   value="{{ $task->start_date->format('Y-m-d') }}" 
                                   required readonly placeholder="Pilih tanggal mulai">
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
                            Tanggal Deadline Tugas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 datetime-picker" 
                                   id="deadline" name="deadline" 
                                   value="{{ $task->deadline->format('Y-m-d') }}" 
                                   required readonly placeholder="Pilih tanggal deadline">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <div class="text-red-500 text-sm mt-1 hidden invalid-feedback"></div>
                    </div>
                </div>

                <!-- Current Status Display -->
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                    <h3 class="text-lg font-semibold text-purple-800 mb-3 flex items-center">
                        <i class="fas fa-flag text-purple-600 mr-2"></i>
                        Status Task Saat Ini
                    </h3>
                    <div class="flex items-center">
                        @php
                            $statusConfig = [
                                'Progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '🔄'],
                                'Done' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                'Late' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '⏰'],
                                'Canceled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => '❌'],
                            ];
                            $config = $statusConfig[$task->status] ?? $statusConfig['Progress'];
                        @endphp
                        
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                            {{ $config['icon'] }} {{ $task->status }}
                        </span>
                        <p class="ml-4 text-sm text-purple-700">Status dapat diubah melalui halaman daftar task</p>
                    </div>
                </div>

                <!-- Helper Text -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-yellow-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Tips untuk mengedit task:</h3>
                            <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                                <li>Pastikan judul task jelas dan spesifik</li>
                                <li>Deskripsi sebaiknya detail agar mudah dipahami</li>
                                <li>Periksa tanggal deadline agar realistis</li>
                                <li>Gunakan tombol Reset jika ingin membatalkan perubahan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="button" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-yellow-300 shadow-sm text-sm font-medium rounded-lg text-yellow-700 bg-yellow-50 hover:bg-yellow-100 hover:border-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 transform hover:scale-105" 
                            id="resetBtn">
                        <i class="fas fa-undo mr-2"></i>
                        Reset ke Data Awal
                    </button>
                    
                    <button type="submit" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:scale-105 shadow-lg" 
                            id="updateBtn">
                        <i class="fas fa-save mr-2"></i>
                        Update Task
                    </button>
                    
                    <a href="{{ route('trainee-tasks.index') }}" 
                       class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let originalData = {};

$(document).ready(function() {
    storeOriginalData();
    initializeDatePickers();
    setupFormHandlers();
    setupFormValidation();
});

function storeOriginalData() {
    originalData = {
        task: $('#task').val(),
        desc: $('#desc').val(),
        start_date: $('#start_date').val(),
        deadline: $('#deadline').val()
    };
}

function initializeDatePickers() {
    $('.datetime-picker').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        locale: {
            firstDayOfWeek: 1
        },
        onOpen: function(selectedDates, dateStr, instance) {
            instance.element.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
        },
        onClose: function(selectedDates, dateStr, instance) {
            instance.element.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
            
            // Validate dates when both are selected
            if ($('#start_date').val() && $('#deadline').val()) {
                validateDateRange();
            }
        }
    });
}

function setupFormHandlers() {
    // Reset button with confirmation
    $('#resetBtn').on('click', function() {
        // Check if there are any changes
        let hasChanges = false;
        if ($('#task').val() !== originalData.task ||
            $('#desc').val() !== originalData.desc ||
            $('#start_date').val() !== originalData.start_date ||
            $('#deadline').val() !== originalData.deadline) {
            hasChanges = true;
        }

        if (hasChanges) {
            Swal.fire({
                title: 'Konfirmasi Reset',
                text: 'Apakah Anda yakin ingin mengembalikan semua data ke nilai awal? Perubahan yang sudah dilakukan akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded mr-3',
                    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    resetToOriginal();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil direset ke nilai awal',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        } else {
            resetToOriginal();
            Swal.fire({
                title: 'Info',
                text: 'Tidak ada perubahan untuk direset',
                icon: 'info',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });

    // Form submission
    $('#editTaskForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Apakah Anda yakin ingin menyimpan perubahan task ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mr-3',
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
    $('#editTaskForm [required]').on('blur', function() {
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
        showFieldError($('#deadline'), 'Tanggal deadline harus setelah tanggal start');
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
    $('#editTaskForm [required]').each(function() {
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
            confirmButtonText: 'OK'
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

function submitForm() {
    // Disable buttons during submission
    $('#updateBtn, #resetBtn').prop('disabled', true);
    $('#updateBtn').html('<i class="fas fa-spinner fa-spin mr-2"></i> Memperbarui...');
    
    // Show loading overlay
    Swal.fire({
        title: 'Memperbarui Data',
        text: 'Mohon tunggu, sedang memproses...',
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    let formData = new FormData($('#editTaskForm')[0]);

    $.ajax({
        url: '{{ route("trainee-tasks.update", $task->id) }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.close();
            
            if (response.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message || 'Task berhasil diperbarui',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '{{ route("trainee-tasks.index") }}';
                });
            } else {
                enableButtons();
                Swal.fire('Error', 'Terjadi kesalahan saat memperbarui data', 'error');
            }
        },
        error: function(xhr) {
            Swal.close();
            
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                displayValidationErrors(errors);
                Swal.fire({
                    title: 'Validasi Error',
                    text: 'Terdapat kesalahan pada input form',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                let message = xhr.responseJSON?.message || 'Terjadi kesalahan saat memperbarui data';
                Swal.fire('Error', message, 'error');
            }
            
            enableButtons();
        }
    });
}

function enableButtons() {
    $('#updateBtn, #resetBtn').prop('disabled', false);
    $('#updateBtn').html('<i class="fas fa-save mr-2"></i> Update Task');
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

function resetToOriginal() {
    $('#task').val(originalData.task);
    $('#desc').val(originalData.desc);
    $('#start_date').val(originalData.start_date);
    $('#deadline').val(originalData.deadline);
    
    // Clear validation errors
    $('.border-red-500').removeClass('border-red-500').addClass('border-gray-300');
    $('.invalid-feedback').addClass('hidden').empty();
    
    // Update flatpickr values
    if (document.getElementById('start_date')._flatpickr) {
        document.getElementById('start_date')._flatpickr.setDate(originalData.start_date);
    }
    if (document.getElementById('deadline')._flatpickr) {
        document.getElementById('deadline')._flatpickr.setDate(originalData.deadline);
    }
}
</script>
@endsection