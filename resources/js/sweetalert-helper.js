// SweetAlert2 utilities for Laravel
window.SweetAlertHelper = {
    // Success message
    success: function (message, title = 'Berhasil!') {
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonColor: '#10B981',
            timer: 3000,
            timerProgressBar: true
        });
    },

    // Error message
    error: function (message, title = 'Error!') {
        Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            confirmButtonColor: '#EF4444'
        });
    },

    // Warning message
    warning: function (message, title = 'Peringatan!') {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: message,
            confirmButtonColor: '#F59E0B'
        });
    },

    // Info message
    info: function (message, title = 'Info') {
        Swal.fire({
            icon: 'info',
            title: title,
            text: message,
            confirmButtonColor: '#3B82F6'
        });
    },

    // Confirmation dialog
    confirm: function (message, title = 'Apakah Anda yakin?', options = {}) {
        const defaultOptions = {
            icon: 'question',
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        };

        return Swal.fire({ ...defaultOptions, ...options });
    },

    // Delete confirmation
    confirmDelete: function (message = 'Data ini akan dihapus secara permanen', title = 'Hapus Data?') {
        return this.confirm(message, title, {
            icon: 'warning',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        });
    },

    // Form submission with loading
    submitWithLoading: function (form, loadingText = 'Menyimpan...') {
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>' + loadingText;
        }
    },

    // Reset form after submission
    resetForm: function (form) {
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Simpan';
        }
    }
};

// Auto-show flash messages from Laravel
document.addEventListener('DOMContentLoaded', function () {
    // Success messages
    const successAlert = document.querySelector('.alert-success, [class*="success"]');
    if (successAlert) {
        const message = successAlert.textContent.trim();
        if (message) {
            window.SweetAlertHelper.success(message);
            successAlert.remove();
        }
    }

    // Error messages
    const errorAlert = document.querySelector('.alert-danger, .alert-error, [class*="error"]');
    if (errorAlert) {
        const message = errorAlert.textContent.trim();
        if (message) {
            window.SweetAlertHelper.error(message);
            errorAlert.remove();
        }
    }

    // Warning messages
    const warningAlert = document.querySelector('.alert-warning, [class*="warning"]');
    if (warningAlert) {
        const message = warningAlert.textContent.trim();
        if (message) {
            window.SweetAlertHelper.warning(message);
            warningAlert.remove();
        }
    }

    // Handle delete forms with SweetAlert2
    document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const message = form.getAttribute('data-confirm-delete') || 'Data ini akan dihapus secara permanen';
            const title = form.getAttribute('data-confirm-title') || 'Hapus Data?';

            window.SweetAlertHelper.confirmDelete(message, title).then((result) => {
                if (result.isConfirmed) {
                    window.SweetAlertHelper.submitWithLoading(form, 'Menghapus...');
                    form.submit();
                }
            });
        });
    });

    // Handle forms with loading
    document.querySelectorAll('form[data-loading]').forEach(form => {
        form.addEventListener('submit', function (e) {
            const loadingText = form.getAttribute('data-loading') || 'Menyimpan...';
            window.SweetAlertHelper.submitWithLoading(form, loadingText);
        });
    });

    // Store original button text
    document.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(btn => {
        if (!btn.getAttribute('data-original-text')) {
            btn.setAttribute('data-original-text', btn.innerHTML);
        }
    });
});
