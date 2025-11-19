@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h4 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-tasks text-primary-500 mr-2"></i>
                        Trainee Tasks
                    </h4>
                    <p class="text-sm text-gray-600 mt-1">Manage and track all tasks</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('trainee-tasks.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200 transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        CREATE
                    </a>
                    
                    <button type="button" 
                            onclick="openFilterModal()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200 transform hover:scale-105">
                        <i class="fas fa-filter mr-2"></i>
                        FILTER
                    </button>
                    
                    <button type="button" 
                            onclick="importData()"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200 transform hover:scale-105">
                        <i class="fas fa-file-import mr-2"></i>
                        IMPORT
                    </button>
                    
                    @if(Auth::guard('admin')->check())
                    <button type="button" 
                            id="bulkDeleteBtn" 
                            style="display: none;"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200 transform hover:scale-105">
                        <i class="fas fa-trash mr-2"></i>
                        DELETE
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="tasksTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if(Auth::guard('admin')->check())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                <div class="flex items-center">
                                    <input type="checkbox" id="selectAll" 
                                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                </div>
                            </th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    Nama Trainee
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-list mr-2"></i>
                                    Tugas
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    Tanggal Start
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-times mr-2"></i>
                                    Tanggal Deadline
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-flag mr-2"></i>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-2"></i>
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-filter text-blue-500 mr-2"></i>
                    Filter Data
                </h3>
                <button onclick="closeFilterModal()" 
                        class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="py-4">
                <form id="filterForm" class="space-y-4">
                    <div>
                        <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag text-gray-400 mr-1"></i>
                            Status
                        </label>
                        <select id="status_filter" name="status" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Progress">Progress</option>
                            <option value="Done">Done</option>
                            <option value="Late">Late</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end pt-3 border-t border-gray-200 space-x-2">
                <button onclick="closeFilterModal()" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-200">
                    <i class="fas fa-times mr-1"></i>
                    Close
                </button>
                <button onclick="applyFilter()" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                    <i class="fas fa-check mr-1"></i>
                    Apply Filter
                </button>
                <button onclick="exportData()" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-200">
                    <i class="fas fa-file-export mr-1"></i>
                    Export Excel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-file-import text-yellow-500 mr-2"></i>
                    Import Data
                </h3>
                <button onclick="closeImportModal()" 
                        class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="py-4">
                <form id="importForm" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-excel text-green-600 mr-1"></i>
                            Pilih File Excel
                        </label>
                        <input type="file" 
                               id="excel_file" 
                               name="excel_file" 
                               accept=".xlsx,.xls"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                    </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end pt-3 border-t border-gray-200 space-x-2">
                <button onclick="closeImportModal()" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-200">
                    <i class="fas fa-times mr-1"></i>
                    Cancel
                </button>
                <button onclick="submitImport()" 
                        class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition duration-200">
                    <i class="fas fa-upload mr-1"></i>
                    Import
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let table;
let currentFilter = {};

$(document).ready(function() {
    initializeDataTable();
    setupEventListeners();
});

function initializeDataTable() {
    let columns = [
        @if(Auth::guard('admin')->check())
        { 
            data: 'checkbox', 
            orderable: false, 
            searchable: false,
            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'
        },
        @endif
        { 
            data: 'trainee_name', 
            name: 'trainee.name',
            className: 'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'
        },
        { 
            data: 'task',
            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-xs truncate'
        },
        { 
            data: 'formatted_start_date',
            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'
        },
        { 
            data: 'formatted_deadline',
            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'
        },
        { 
            data: 'status_dropdown', 
            orderable: false, 
            searchable: false,
            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'
        },
        { 
            data: 'action', 
            orderable: false, 
            searchable: false,
            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'
        }
    ];

    table = $('#tasksTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("trainee-tasks.data") }}',
            data: function(d) {
                return $.extend({}, d, currentFilter);
            }
        },
        columns: columns,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="flex items-center justify-center"><i class="fas fa-spinner fa-spin mr-2"></i>Loading...</div>',
            search: '',
            searchPlaceholder: 'Search tasks...',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        },
        dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"<"mb-2 sm:mb-0"l><"flex-1 sm:flex-initial"f>>rtip',
        drawCallback: function(settings) {
            // Apply Tailwind styles to DataTable elements
            $('.dataTables_length select').addClass('px-3 py-1 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500');
            $('.dataTables_filter input').addClass('px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
            $('.dataTables_paginate .paginate_button').addClass('px-3 py-1 mx-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition duration-200');
            $('.dataTables_paginate .paginate_button.current').addClass('bg-blue-500 text-white border-blue-500');
        }
    });
}

function setupEventListeners() {
    // Status dropdown functionality
    $(document).on('click', '.status-btn', function(e) {
        e.preventDefault();
        $('.status-options').hide();
        $(this).next('.status-options').toggle();
    });

    // Status change
    $(document).on('click', '.status-option', function(e) {
        e.preventDefault();
        let status = $(this).data('status');
        let taskId = $(this).closest('.dropdown').find('.status-btn').data('task-id');
        
        updateStatus(taskId, status);
        $('.status-options').hide();
    });

    // Hide dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.status-options').hide();
        }
    });

    @if(Auth::guard('admin')->check())
    // Select all checkbox
    $('#selectAll').on('click', function() {
        $('input[name="task_ids[]"]').prop('checked', this.checked);
        toggleBulkDeleteButton();
    });

    // Individual checkbox
    $(document).on('change', 'input[name="task_ids[]"]', function() {
        toggleBulkDeleteButton();
    });

    // Bulk delete button
    $('#bulkDeleteBtn').on('click', function() {
        bulkDelete();
    });
    @endif
}

// Modal Functions
function openFilterModal() {
    document.getElementById('filterModal').classList.remove('hidden');
}

function closeFilterModal() {
    document.getElementById('filterModal').classList.add('hidden');
}

function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}

function updateStatus(taskId, status) {
    $.ajax({
        url: `/trainee-tasks/${taskId}/status`,
        method: 'PATCH',
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                table.ajax.reload();
                Swal.fire('Success', response.message, 'success');
            }
        },
        error: function() {
            Swal.fire('Error', 'Gagal mengupdate status', 'error');
        }
    });
}

@if(Auth::guard('admin')->check())
function toggleBulkDeleteButton() {
    let checkedCount = $('input[name="task_ids[]"]:checked').length;
    if (checkedCount > 0) {
        $('#bulkDeleteBtn').show();
    } else {
        $('#bulkDeleteBtn').hide();
    }
}

function bulkDelete() {
    let taskIds = [];
    $('input[name="task_ids[]"]:checked').each(function() {
        taskIds.push($(this).val());
    });

    if (taskIds.length === 0) {
        Swal.fire('Warning', 'Pilih minimal 1 task untuk dihapus', 'warning');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi',
        text: `Hapus ${taskIds.length} task yang dipilih?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded mr-3',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("trainee-tasks.bulk-delete") }}',
                method: 'DELETE',
                data: {
                    task_ids: taskIds,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                        $('#selectAll').prop('checked', false);
                        $('#bulkDeleteBtn').hide();
                        Swal.fire('Success', response.message, 'success');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            });
        }
    });
}
@endif

function applyFilter() {
    currentFilter.status = $('#status_filter').val();
    table.ajax.reload();
    closeFilterModal();
    
    // Show filter indicator
    if (currentFilter.status) {
        Swal.fire({
            title: 'Filter Applied',
            text: `Showing tasks with status: ${currentFilter.status}`,
            icon: 'info',
            timer: 2000,
            showConfirmButton: false
        });
    }
}

function importData() {
    openImportModal();
}

function submitImport() {
    let fileInput = document.getElementById('excel_file');
    let file = fileInput.files[0];
    
    if (!file) {
        Swal.fire('Warning', 'Pilih file Excel terlebih dahulu', 'warning');
        return;
    }

    // Validate file type
    const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    if (!allowedTypes.includes(file.type)) {
        Swal.fire('Error', 'File harus berformat Excel (.xlsx atau .xls)', 'error');
        return;
    }

    // Show loading
    Swal.fire({
        title: 'Importing...',
        text: 'Please wait while we process your file',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    let formData = new FormData();
    formData.append('excel_file', file);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: '{{ route("trainee-tasks.import") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#importModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Success', response.message, 'success');
                $('#importForm')[0].reset();
            }
        },
        error: function(xhr) {
            let message = xhr.responseJSON?.message || 'Gagal mengimport data';
            Swal.fire('Error', message, 'error');
        }
    });
}

function exportData() {
    let status = $('#status_filter').val();
    let url = '{{ route("trainee-tasks.export") }}';
    
    // Add status filter to URL if exists
    if (status) {
        url += '?status=' + encodeURIComponent(status);
    }
    
    // Show loading
    Swal.fire({
        title: 'Exporting...',
        text: 'Please wait while we prepare your Excel file',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Create temporary link to download file
    const link = document.createElement('a');
    link.href = url;
    link.download = 'trainee-tasks-export.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Close loading after short delay
    setTimeout(() => {
        Swal.close();
        $('#filterModal').modal('hide');
        Swal.fire('Success', 'Excel file has been downloaded!', 'success');
    }, 1500);
}

// Close modals when clicking outside
window.onclick = function(event) {
    const filterModal = document.getElementById('filterModal');
    const importModal = document.getElementById('importModal');
    
    if (event.target == filterModal) {
        closeFilterModal();
    }
    if (event.target == importModal) {
        closeImportModal();
    }
}

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeFilterModal();
        closeImportModal();
    }
});
</script>
@endsection