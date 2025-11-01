jadi rencannya mau bikin fitur pemodelan RFM. recency, frequency, monetary. nanti datanya dapet dari transaksi yang bakal diimport sama admin umkm. nah untuk datanya tuh bisa diinput oleh user satu satu, atua dari template excel yang disediakan oleh aplikasi jadi aplikasi bisa nerima inputan excel. nah setelah datanya masuk, nanti aplikasi bakal ngitung RFMnya terus nampilin di dashboard umkm. 
untuk dashboard nya  nanti ada info terkait pelanggan aktif, pelanggan lama , pelanggan baru dan total pelanggan. kemudian ada data pelangan per klaster

kemudian ada data statistik pada tiap klaster mean median modus
untuk klasterisasi nya iitu make rulebased yang ada di referensi ini ya 
misal klaster best te, uncategorized dll

untuk klaster ini juga d bagi per pleanggan. misal pelanggan student dan regular

untuk data pelanggannya itu ada id pelnggan, nama lengkap jenis kelamin, jenis pelanggan, 

nah untuk rulebased klasterisasi nya itu sebagai berikut:
Pengecekan Pertama (Recency):
- Sistem akan memeriksa apakah nilai recency pelanggan lebih besar dari threshold recency yang telah ditentukan. Dalam RFM, nilai recency yang lebih kecil (pelanggan baru saja bertransaksi) dianggap lebih baik.
- Ya (Jalur Atas): Jika recency pelanggan lebih besar dari threshold (artinya, sudah lama tidak bertransaksi).
Tidak (Jalur Bawah): Jika recency pelanggan lebih kecil atau sama dengan threshold (artinya, belum lama bertransaksi).
Pengecekan Kedua (Frequency):
- Setelah jalur Recency ditentukan, sistem memeriksa nilai frequency pelanggan.
- Ya: Jika frequency pelanggan lebih besar dari threshold (artinya, sering bertransaksi).
- Tidak: Jika frequency pelanggan lebih kecil atau sama dengan threshold (artinya, jarang bertransaksi).
Pengecekan Ketiga (Monetary):
Langkah terakhir adalah memeriksa nilai monetary pelanggan.
- Ya: Jika nilai monetary lebih besar dari threshold (artinya, nilai transaksinya tinggi).
- Tidak: Jika nilai monetary lebih kecil atau sama dengan threshold (artinya, nilai transaksinya rendah).


nah disini threshold disini maksutnya adalah nilai batas yang ditentukan untuk masing-masing metrik RFM (Recency, Frequency, Monetary).