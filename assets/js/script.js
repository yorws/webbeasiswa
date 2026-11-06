/*
 * File: script.js
 * Deskripsi: Menangani validasi form (email, no HP), dan logika UI berdasarkan nilai IPK.
 * Author: Antigravity IDE
 * Versi/Tanggal: 1.0 / 2026-07-04
 */

document.addEventListener("DOMContentLoaded", function () {

    const beasiswaForm = document.getElementById("formBeasiswa");
    if (beasiswaForm) {

        // Elemen-elemen yang perlu dimanipulasi berdasarkan nilai IPK
        const ipkInput = document.getElementById("ipk");
        const beasiswaSelect = document.getElementById("pilihan_beasiswa");
        const berkasInput = document.getElementById("berkas");
        const btnDaftar = document.getElementById("btnDaftar");

        // Fungsi untuk mengupdate state form berdasarkan IPK
        function updateFormState() {
            const ipkValue = parseFloat(ipkInput.value);

            // Hapus alert lama jika ada
            const oldAlert = document.getElementById("ipk-alert");
            if (oldAlert) {
                oldAlert.remove();
            }

            // Logika 1 & 2: Pengecekan IPK >= 3 atau < 3
            if (ipkValue < 3.0) {
                // Jika IPK kurang dari 3, disable pilihan beasiswa, upload berkas, dan tombol daftar
                beasiswaSelect.disabled = true;
                beasiswaSelect.value = ""; // Reset pilihan
                berkasInput.disabled = true;
                btnDaftar.disabled = true;

                // Tambahkan pesan visual
                const alertMsg = document.createElement("div");
                alertMsg.id = "ipk-alert";
                alertMsg.className = "alert alert-warning mt-3";
                alertMsg.innerHTML = "<strong>Perhatian:</strong> IPK Anda (" + ipkValue + ") di bawah persyaratan (minimal 3.0). Anda tidak dapat melanjutkan pendaftaran.";
                ipkInput.parentNode.appendChild(alertMsg);
            } else {
                // Jika IPK >= 3, aktifkan elemen dan beri fokus pada pilihan beasiswa
                beasiswaSelect.disabled = false;
                berkasInput.disabled = false;
                btnDaftar.disabled = false;

                // Auto focus ke pilihan beasiswa
                beasiswaSelect.focus();
            }
        }

        // Panggil saat form pertama kali dimuat
        updateFormState();

        // Panggil saat dropdown IPK diubah nilainya
        ipkInput.addEventListener("change", updateFormState);

        // Validasi form saat disubmit
        beasiswaForm.addEventListener("submit", function (event) {
            let isValid = true;

            // Validasi Email
            const emailInput = document.getElementById("email");
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value)) {
                alert("Format email tidak valid.");
                isValid = false;
                emailInput.focus();
            }

            // Validasi Nomor HP (Hanya Angka)
            const hpInput = document.getElementById("nomor_hp");
            const hpPattern = /^[0-9]+$/;
            if (isValid && !hpPattern.test(hpInput.value)) {
                alert("Nomor HP hanya boleh berisi angka.");
                isValid = false;
                hpInput.focus();
            }

            // Validasi pilihan beasiswa jika aktif
            if (isValid && !beasiswaSelect.disabled && beasiswaSelect.value === "") {
                alert("Silakan pilih jenis beasiswa.");
                isValid = false;
                beasiswaSelect.focus();
            }

            // Validasi upload berkas jika aktif
            if (isValid && !berkasInput.disabled && berkasInput.files.length === 0) {
                alert("Silakan unggah berkas syarat.");
                isValid = false;
                berkasInput.focus();
            }

            if (!isValid) {
                event.preventDefault(); // Mencegah form dikirim jika tidak valid
            }

            // Jika valid, biarkan form disubmit (PHP akan menangani sisanya)
        });

        // Validasi real-time untuk input Nomor HP agar user tidak bisa mengetik huruf
        const hpInputRealtime = document.getElementById("nomor_hp");
        hpInputRealtime.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});
