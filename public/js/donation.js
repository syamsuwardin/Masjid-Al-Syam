'use strict';

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formDonasi');
    if (!form) return;

    function formatRupiah(input) {
        let number = input.value.replace(/[^\d]/g, '');
        let formatted = new Intl.NumberFormat('id-ID').format(number);
        input.value = formatted;
    }

    function validateForm(e) {
        const nama = document.getElementById('nama').value.trim();
        const email = document.getElementById('email').value.trim();
        const jumlah = document.getElementById('jumlah').value.replace(/\./g, '');
        
        // Validate name
        if (!/^[A-Za-z\s]+$/.test(nama)) {
            e.preventDefault();
            alert('Nama hanya boleh menggunakan huruf');
            return false;
        }
        
        // Validate email
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            e.preventDefault();
            alert('Format email tidak valid');
            return false;
        }
        
        // Validate amount
        if (parseInt(jumlah) < 10000) {
            e.preventDefault();
            alert('Minimal donasi Rp 10.000');
            return false;
        }

        // Clean amount before submit
        document.getElementById('jumlah').value = jumlah;
    }

    // Event listeners
    document.getElementById('jumlah').addEventListener('keyup', function(e) {
        formatRupiah(this);
    });

    document.getElementById('nama').addEventListener('keypress', function(e) {
        if (!/[A-Za-z\s]/.test(e.key)) {
            e.preventDefault();
        }
    });

    form.addEventListener('submit', validateForm);
});