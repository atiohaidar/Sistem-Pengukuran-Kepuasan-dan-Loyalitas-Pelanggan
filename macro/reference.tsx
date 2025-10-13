import React, { useState, useMemo } from 'react';
import { createRoot } from 'react-dom/client';

// --- DATA CONSTANTS ---

const MATURITY_INSIGHTS = [
    {
        title: 'Pre-Perancanan Sistem pengelolaan pelanggan',
        description: "Organisasi menyadari pentingnya sistem manajemen pelanggan, namun belum sampai pada tahap di mana proyek mengelola pelanggan telah dirancang secara lengkap. Pada tahap ini, organisasi sebaiknya mulai mempertimbangkan implikasi penerapan sistem manajemen pelanggan terhadap struktur dan proses mereka.\n\nBeberapa strategi arah pengembangan sistem manajemen pelanggan yang dapat dilakukan untuk meningkatkan maturitas sistem manajemen pelanggan adalah dengan melakukan audit menggunakan CRM Readiness Audit Payne dan menyusun rencana membangun infrastruktur data"
    },
    {
        title: 'Membangun repositori data',
        description: "Organisasi sudah mulai mengumpulkan dan meninjau data pelanggan. Untuk itu perlu dibangun repositori data agar dapat mendukung tugas-tugas sistem manajemen pelanggan baik secara analitis maupun operasional.\n\nLangkah untuk mengembangkan sistem manajemen pelanggan adalah dengan meningkatkan kualitas dan kelengkapan data pelanggan, mengintegrasikan sistem pengelolaan pelanggan dengan sistem operasional perusahaan, dan mengembangkan kapabilitas analitik dasar"
    },
    {
        title: 'Sistem pengelolaan pelanggan berkembang secara moderat',
        description: "Organisasi pada tahap ini mulai mengubah pendekatan dengan mengimplementasikan segmentasi sebagai hasil dari pembangunan data warehouse, sehingga segmentasi menjadi lebih berbasis data.\n\nUntuk meningkatkan sistem manajemen pelanggan organisasi dapat meningkatkan kemampuan segmentasi pelanggan dengan berbasis value dan mengembangkan sistem pelaporan dan analitik prediktif untuk sistem manajemen pelanggan"
    },
    {
        title: 'Sistem pengelolaan pelanggan berkembang dengan baik',
        description: "Organisasi mulai membangun data warehouse berskala perusahaan, memperluas basis pengguna dan meningkatkan jumlah pengguna, serta mulai mengembangkan tools front-office. Tugas utama pada tahap ini adalah memprioritaskan pelanggan dan menggunakan campaign management secara lebih efektif dengan memanfaatkan data warehouse sepenuhnya.\n\nLangkah yang dapat dilakukan untuk membangun sistem manajemen pelanggan yang lebih maju lagi adalah dengan mengembangkan teknik penggunaan data sains, mengintegrasikan sistem antar departemen, dan menggunakan alat visualisasi data untuk melakukan manajemen pelanggan"
    },
    {
        title: 'Sistem pengelolaan pelanggan sangat maju',
        description: "Organisasi telah terintegrasi sepenuhnya, dengan akses data warehouse yang luas di seluruh fungsi departemen menggunakan teknik yang canggih. Tugas utama pada tahap ini adalah pengelolaan pelanggan yang lebih aktif melalui campaign management yang memungkinkan dialog berkelanjutan dengan pelanggan dan memaksimalkan potensi keuntungan sepanjang siklus hidup pelanggan."
    }
];

const RECOMMENDATIONS = {
    'Strategy development': "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan strategi. Proses ini berfokus pada menyuarakan apa tujuan bisnis UMKM dan siapa pelanggan yang paling penting untuk dilayani. Dengan memperjelas tujuan jangka panjang, usaha dapat fokus dan tidak mudah terombang-ambing oleh persaingan.\n\nLangkah yang perlu diambil oleh perusahaan adalah menentukan tujuan dan visi perusahaan dalam jangka panjang, serta nilai-nilai yang akan diimplementasikan dalam keberjalanan bisnis. Dengan menyatakan tujuan yang jelas, keputusan sehari-hari dalam pengelolaan pelanggan akan lebih terarah dan sesuai. Selanjutnya, perusahaan juga harus melakukan analisis kompetitor dan mengidentifikasi posisi perusahaan di pasar untuk melihat apa keunikan perusahaan jika dibandingkan dengan kompetitor.\n\nSelain itu, penting juga menentukan kelompok pelanggan yang paling utama atau segmentasi pelanggan. Penentuan ini dilakukan karena tidak semua pelanggan bisa diperlakukan sama. Ada pelanggan yang hanya membeli sekali, ada yang rutin, ada pula yang aktif memberi rekomendasi. Strategi akan lebih efektif jika UMKM memilih kelompok mana yang akan lebih diprioritaskan. Misalnya apakah perusahaan ingin melakukan akuisisi atau retensi pelanggan.",
    'Value creation': "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses pengembangan nilai. Bagi pelanggan, nilai tidak hanya datang dari produk atau jasa, tetapi dari keseluruhan pengalaman. Untuk itu, UMKM dapat menambah nilai perusahaan melalui hal-hal sederhana, seperti layanan yang ramah, respon cepat dalam menanggapi layanan atau keluhan, diskon bagi pelanggan setia, atau edukasi bermanfaat terkait produk. Penambahan nilai ini tidak hanya memenuhi kebutuhan utama pelanggan atas produk, tapi bisa juga melebihi ekspektasi atau menyadarkan pelanggan akan kebutuhan fitur tersebut. Perusahaan dapat melakukan hal ini untuk meningkatkan hubungan dengan pelanggan agar nantinya pelanggan dapat memberikan rekomendasi kepada orang lain secara mouth-to-mouth dan mengehemat biaya pemasaran.\n\nDi sisi lain, nilai yang diciptakan juga harus memberi keuntungan balik bagi usaha. Nilai itu bisa berupa peningkatan jumlah pelanggan yang datang kembali (retensi), penjualan produk tambahan (cross-selling), atau semakin banyak pelanggan baru (akusisi) melalui rekomendasi.",
    'Multi-channel integration': "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen hubungan dengan pelanggan. Interaksi dengan pelanggan perlu dilakukan melalui berbagai saluran komunikasi yang konsisten dan mudah diakses. Saluran ini bisa berupa komunikasi langsung, telepon, media sosial, atau aplikasi pesan. Tidak harus menggunakan semua saluran sekaligus, yang lebih penting adalah memilih saluran yang paling sesuai dengan kebutuhan pelanggan dan memastikan setiap saluran tersebut dikelola dengan baik.\nKecepatan dan konsistensi dalam merespons pelanggan juga menjadi faktor yan penting dalam pengelolaan pelanggan. Ketika saluran komunikasi sudah ditentukan, usaha perlu menjaga agar pelanggan merasa mudah terhubung dan selalu mendapatkan jawaban yang jelas. Dengan begitu, saluran yang digunakan tidak hanya menjadi media komunikasi, tetapi juga sarana untuk membangun hubungan yang lebih kuat dengan pelanggan.",
    'Information management': "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen informasi. Informasi tentang pelanggan merupakan aset penting yang harus dimilikki dan dikelola dengan baik. Untuk itu perusahaan dapat memperhatikan mengenai proses pengumpulan, penyimpanan, dan pengintegrasian informasi perusahaan agar perusahaan dapat memahami pelanggan lebih jauh. Proses ini dapat dilakukan dengan cara sederhana menggunakan dokumen digital atau aplikasi pendukung yang sesuai kemampuan usaha. Data-data yang sudah dikumpulkan dapat diolah dan di analisis menggunakan data mining, clustering, atau metode lainnya untuk mendapatkan insights dari informasi mengenai pelanggan.\nSelain pengumpulan dan pengolahan data, perusahaan juga harus mempertimbangkan komponen yang terkait dengan sistem teknologi informasi seperti, perangkat keras, perangkat lunak, dan middleware yang digunakan perusahaan untuk mengelola pelanggan. Perangkat keras terdiri atas alat fisik seperti komputer, laptop, server, keyboard. Perangkat lunak merupakan program komputer yang digunakan untuk mengelola data pelanggan. Sedangkan middleware, merupakan program antara keinginan pelanggan dan server sehingga pelanggan dan sistem dapat berinteraksi dari tempat yang berbeda.\nTerakhir, perusahaan perlu mempertimbangkan aplikasi front-office dan back-office untuk mendukung aktivitas baik langsung dengan pelanggan, maupun dengan administrasi internal dan pemasok. Informasi yang rapi akan memudahkan perusahaan untuk mengenali pola perilaku pelangganya dan melihat potensi kebutuhan dari pelanggan.",
    'Performance assessment': "Dalam rangka mengembangkan sistem pengelolaan pelanggan, perusahaan perlu berfokus pada proses manajemen kinerja. Proses manajemen kinerja merupakan proses untuk memastikan bahwa strategi perusahaan terkait sistem pengelolaan pelanggan dijalankan dan memenuhi kebutuhan yang sudah ditentukan. Evaluasi kinerja dapat dilakukan dengan menetapkan indikator sederhana, seperti tingkat kepuasan pelanggan, jumlah pelanggan kembali, atau frekuensi pembelian pelanggan. Jika perusahaan sudah semakin maju, maka pengukuran kinerja dapat dilakukan dengan membangun balanced scorecard, service-profit chain, atau membangun key performance indicatior untuk perusahaan agar dapat melihat ketercapiannya.\n\nEvaluasi tidak harus rumit, yang penting dilakukan secara rutin dan hasilnya dicatat untuk menjadi bahan perbaikan. Dengan adanya catatan evaluasi, usaha dapat melihat perkembangan dari waktu ke waktu dan mengetahui area mana yang sudah berjalan baik serta area mana yang masih membutuhkan perhatian lebih. Hal ini membuat pengelolaan pelanggan tidak hanya bersifat reaktif, tetapi juga dapat diarahkan untuk terus berkembang."
};


const MATURITY_QUESTIONS = [
    {
        id: 'visi', label: 'Visi', description: 'Arah masa depan bisnis berfokus pada pelanggan', options: [
            { value: 1, text: 'Tidak memiliki visi terkait pelanggan' },
            { value: 2, text: 'Mulai memiliki inisiatif terkait pelanggan namun belum terintegrasi ke visi' },
            { value: 3, text: 'Visi berorientasi pelanggan mulai diterapkan di masing-masing fungsi' },
            { value: 4, text: 'Visi berorientasi pelanggan diadopsi di seluruh unit bisnis internal' },
            { value: 5, text: 'Visi berorientasi pelanggan diadopsi di unit bisnis internal dan eksternal' },
        ]
    },
    {
        id: 'strategi', label: 'Strategi', description: 'Pendekatan strategis untuk manajemen pelanggan', options: [
            { value: 1, text: 'Tidak ada strategi SPP' },
            { value: 2, text: 'Proyek SPP dimulai tanpa koordinasi dan belum terarah' },
            { value: 3, text: 'Ada kesadaran strategis SPP tapi masih antar departemen' },
            { value: 4, text: 'SPP dikelola terpusat dengan dukungan antar fungsi' },
            { value: 5, text: 'SPP dikembangkan bersama mitra untuk manfaat bersama' },
        ]
    },
    {
        id: 'pengalamanKonsumen', label: 'Pengalaman Konsumen', description: 'Memberikan pengalaman kepada pelanggan yang konsisten', options: [
            { value: 1, text: 'Tidak ada konsep dan didesain dengan sendiri' },
            { value: 2, text: 'Tidak ada konsep dan didesain dengan sendiri' },
            { value: 3, text: 'Fokus pada pengalaman konsumen namun hanya di fungsi tertentu' },
            { value: 4, text: 'Fokus pada pengalaman konsumen mulai lintas unit' },
            { value: 5, text: 'Pengalaman pelanggan dikelola bersama internal dan eksternal' },
        ]
    },
    {
        id: 'kolaborasiOrganisasi', label: 'Kolaborasi Organisasi', description: 'Kolaborasi lintas fungsi untuk fokus pelanggan', options: [
            { value: 1, text: 'Setiap departemen bekerja sendiri dan tidak berfokus pada pelanggan' },
            { value: 2, text: 'Ada inisiatif untuk berfokus pada pelanggan tapi terkendala SILO' },
            { value: 3, text: 'Budaya organisasi mulai bergeser mendukung kolaborasi' },
            { value: 4, text: 'Struktur organisasi dirancang berdasarkan segmen pelanggan' },
            { value: 5, text: 'Pihak internal dan eksternal bekerja sama dengan tujuan yang sama' },
        ]
    },
    {
        id: 'proses', label: 'Proses', description: 'Proses bisnis yang mendukung pelanggan', options: [
            { value: 1, text: 'Proses belum dirancang untuk kepuasan pelanggan (efisiensi internal)' },
            { value: 2, text: 'Proses sudah diperbaiki oleh tiap departemen namun belum menyatu' },
            { value: 3, text: 'Proses sudah memperhatikan efisiensi dan nilai di level departemen' },
            { value: 4, text: 'Proses berorientasi pelanggan mulai diintegrasikan lintas fungsi' },
            { value: 5, text: 'Proses terintegrasi dari awal hingga akhir melibatkan pelanggan & mitra' },
        ]
    },
    {
        id: 'informasi', label: 'Informasi', description: 'Penggunaan data pelanggan', options: [
            { value: 1, text: 'Data tersebar, tidak konsisten, dan tidak digunakan' },
            { value: 2, text: 'Data digunakan secara lokal di tim, tidak dibagikan' },
            { value: 3, text: 'Ada pemanfaatan data dalam unit, mulai terlihat insight' },
            { value: 4, text: 'Insight dibagikan ke seluruh organisasi' },
            { value: 5, text: 'Data dan insight digunakan oleh mitra dan pihak luar' },
        ]
    },
    {
        id: 'teknologi', label: 'Teknologi', description: 'Pemanfaatan teknologi untuk pelanggan', options: [
            { value: 1, text: 'Teknologi SPP sangat terbatas dan tidak mendukung aktivitas bisnis' },
            { value: 2, text: 'Alat SPP hanya digunakan untuk aktivitas dasar dan tidak terintegrasi' },
            { value: 3, text: 'Teknologi SPP mulai kuat namun hanya di departemen tertentu' },
            { value: 4, text: 'Teknologi SPP digunakan lintas departemen dan terintegrasi' },
            { value: 5, text: 'Teknologi SPP terintegrasi dengan mitra & pelanggan secara digital' },
        ]
    },
    {
        id: 'matriks', label: 'Matriks', description: 'Pengukuran kinerja terkait pelanggan', options: [
            { value: 1, text: 'Tidak ada metode pengukuran hanya fokus ke operasional internal' },
            { value: 2, text: 'Matriks hanya untuk efisiensi departemen, bukan untuk pelanggan' },
            { value: 3, text: 'Matriks fokus pada produktivitas, bukan kepuasan pelanggan' },
            { value: 4, text: 'Matriks mencakup aspek pelanggan dan organisasi secara seimbang' },
            { value: 5, text: 'Semua pihak memiliki matriks yang selaras untuk jangka panjang' },
        ]
    },
];

const PRIORITY_ITEMS = [
    { id: 'kepemimpinanStrategis', label: 'Kepemimpinan Strategis', description: 'Tingkat komitmen dan keterlibatan manajemen puncak.' },
    { id: 'posisiKompetitif', label: 'Posisi Kompetitif', description: 'Posisi perusahaan jika dibandingkan dengan perusahaan lainnya.' },
    { id: 'kepuasanPelanggan', label: 'Kepuasan pelanggan', description: 'Kemampuan organisasi dalam memahami, mengukur, dan meningkatkan kepuasan pelanggan.' },
    { id: 'nilaiUmurPelanggan', label: 'Nilai umur pelanggan', description: 'Kemampuan organisasi dalam memahami nilai jangka panjang pelanggan.' },
    { id: 'efisiensiBiaya', label: 'Efisiensi Biaya', description: 'Penggunaan biaya dalam melayani pelanggan secara efisien.' },
    { id: 'aksesPelanggan', label: 'Akses pelanggan', description: 'Efektivitas dan integrasi kanal yang digunakan pelanggan.' },
    { id: 'solusiAplikasiPelanggan', label: 'Solusi dan aplikasi pelanggan', description: 'Evaluasi terhadap solusi dan aplikasi yang digunakan pelanggan.' },
    { id: 'informasiPelanggan', label: 'Informasi Pelanggan', description: 'Kualitas, integritas, dan penggunaan informasi pelanggan.' },
    { id: 'prosesPelanggan', label: 'Proses Pelanggan', description: 'Efisiensi dan efektivitas proses internal yang mendukung pelanggan.' },
    { id: 'standarSDM', label: 'Standar SDM', description: 'Standar kompetensi dan motivasi karyawan dalam memberikan layanan.' },
    { id: 'pelaporanKinerja', label: 'Pelaporan Kinerja', description: 'Ketersediaan sistem pengukuran kinerja SPP secara menyeluruh.' },
];

const READINESS_QUESTIONS = [
    {
        id: 'q1', target: 'kepemimpinanStrategis', label: 'Apakah organisasi saya menunjukkan kepemimpinan dalam proses menjalankan SPP?', options: [
            { value: 1, text: 'Sangat Tidak Setuju' }, { value: 2, text: 'Tidak Setuju' }, { value: 3, text: 'Netral' }, { value: 4, text: 'Setuju' }, { value: 5, text: 'Sangat Setuju' }
        ]
    },
    {
        id: 'q2', target: 'posisiKompetitif', label: 'Bagaimana posisi perusahaan saya jika dibandingkan dengan perusahaan lainnya?', options: [
            { value: 1, text: 'Jauh Lebih Buruk' }, { value: 2, text: 'Lebih Buruk' }, { value: 3, text: 'Setara' }, { value: 4, text: 'Lebih Baik' }, { value: 5, text: 'Jauh Lebih Baik' }
        ]
    },
    {
        id: 'q3', target: 'kepuasanPelanggan', label: 'Seberapa puas pelanggan saya terhadap produk dan layanan yang ditawarkan?', options: [
            { value: 1, text: 'Sangat Tidak Puas' }, { value: 2, text: 'Tidak Puas' }, { value: 3, text: 'Netral' }, { value: 4, text: 'Puas' }, { value: 5, text: 'Sangat Puas' }
        ]
    },
    {
        id: 'q4', target: 'nilaiUmurPelanggan', label: 'Berapa nilai jangka panjang pelanggan saya?', options: [
            { value: 1, text: 'Sangat Rendah' }, { value: 2, text: 'Rendah' }, { value: 3, text: 'Sedang' }, { value: 4, text: 'Tinggi' }, { value: 5, text: 'Sangat Tinggi' }
        ]
    },
    {
        id: 'q5', target: 'efisiensiBiaya', label: 'Apakah saya sudah menggunakan biaya melayani pelanggan secara efisien?', options: [
            { value: 1, text: 'Sangat Tidak Efisien' }, { value: 2, text: 'Tidak Efisien' }, { value: 3, text: 'Netral' }, { value: 4, text: 'Efisien' }, { value: 5, text: 'Sangat Efisien' }
        ]
    },
    {
        id: 'q6', target: 'aksesPelanggan', label: 'Seberapa efektif dan terintegrasi saluran akses yang digunakan pelanggan untuk berhubungan dengan organisasi saya?', options: [
            { value: 1, text: 'Sangat Tidak Efektif' }, { value: 2, text: 'Tidak Efektif' }, { value: 3, text: 'Netral' }, { value: 4, text: 'Efektif' }, { value: 5, text: 'Sangat Efektif' }
        ]
    },
    {
        id: 'q7', target: 'solusiAplikasiPelanggan', label: 'Seberapa efektif solusi dan aplikasi yang memungkinkan pelanggan mendapatkan produk/layanan saya?', options: [
            { value: 1, text: 'Sangat Tidak Efektif' }, { value: 2, text: 'Tidak Efektif' }, { value: 3, text: 'Netral' }, { value: 4, text: 'Efektif' }, { value: 5, text: 'Sangat Efektif' }
        ]
    },
    {
        id: 'q8', target: 'informasiPelanggan', label: 'Bagaimana saya mengelola informasi pelanggan yang digunakan dan dihasilkan dari setiap titik kontak pelanggan?', options: [
            { value: 1, text: 'Sangat Buruk' }, { value: 2, text: 'Buruk' }, { value: 3, text: 'Cukup' }, { value: 4, text: 'Baik' }, { value: 5, text: 'Sangat Baik' }
        ]
    },
    {
        id: 'q9', target: 'prosesPelanggan', label: 'Apakah organisasi saya memiliki proses pelanggan yang sesuai untuk memberikan produk/layanan secara berkualitas?', options: [
            { value: 1, text: 'Tidak ada' }, { value: 2, text: 'Tidak Sesuai' }, { value: 3, text: 'Cukup' }, { value: 4, text: 'Sesuai' }, { value: 5, text: 'Sangat Sesuai' }
        ]
    },
    {
        id: 'q10', target: 'standarSDM', label: 'Apakah saya memiliki sumber daya manusia yang kompeten dan termotivasi untuk memberikan produk/layanan kepada pelanggan?', options: [
            { value: 1, text: 'Tidak Pernah' }, { value: 2, text: 'Jarang' }, { value: 3, text: 'Kadang-kadang' }, { value: 4, text: 'Sebagian Besar' }, { value: 5, text: 'Selalu' }
        ]
    },
    {
        id: 'q11', target: 'pelaporanKinerja', label: 'Apakah organisasi saya memiliki sistem pelaporan kinerja SPP yang sesuai untuk mengukur dampak terhadap hasil bisnis?', options: [
            { value: 1, text: 'Tidak ada' }, { value: 2, text: 'Tidak Sesuai' }, { value: 3, text: 'Cukup' }, { value: 4, text: 'Sesuai' }, { value: 5, text: 'Sangat Sesuai' }
        ]
    },
];

// FIX: Define a type for process group values to ensure strong typing downstream.
type ProcessGroup = {
    name: string;
    items: string[];
    performance: number;
};

const PROCESS_GROUPS: Record<string, ProcessGroup> = {
    'Strategy development': { name: 'Pengembangan Strategi', items: ['kepemimpinanStrategis', 'posisiKompetitif'], performance: 0 },
    'Value creation': { name: 'Pengembangan Nilai', items: ['kepuasanPelanggan', 'nilaiUmurPelanggan'], performance: 0 },
    'Multi-channel integration': { name: 'Manajemen Hubungan Pelanggan', items: ['aksesPelanggan'], performance: 0 },
    'Information management': { name: 'Manajemen Informasi', items: ['informasiPelanggan', 'solusiAplikasiPelanggan'], performance: 0 },
    'Performance assessment': { name: 'Manajemen Kinerja', items: ['prosesPelanggan', 'standarSDM', 'pelaporanKinerja', 'efisiensiBiaya'], performance: 0 },
};

// --- STYLES ---
const styles = {
    button: {
        backgroundColor: 'var(--primary-color)',
        color: 'white',
        border: 'none',
        padding: '0.75rem 1.5rem',
        borderRadius: 'var(--border-radius)',
        cursor: 'pointer',
        fontSize: '1rem',
        fontWeight: '500',
        transition: 'background-color 0.2s',
    },
    buttonDisabled: {
        backgroundColor: 'var(--secondary-color)',
        cursor: 'not-allowed',
    },
    secondaryButton: {
        backgroundColor: 'transparent',
        color: 'var(--primary-color)',
        border: '1px solid var(--primary-color)',
    },
    buttonContainer: {
        display: 'flex',
        justifyContent: 'space-between',
        marginTop: '2rem',
        borderTop: '1px solid var(--gray-color)',
        paddingTop: '1.5rem',
    },
    input: {
        width: '100%',
        padding: '0.5rem',
        fontSize: '1rem',
        border: '1px solid var(--dark-gray-color)',
        borderRadius: 'var(--border-radius)',
        // FIX: Cast 'border-box' to a specific string literal type to satisfy React.CSSProperties.
        boxSizing: 'border-box' as 'border-box',
        color: 'var(--text-color)',
        backgroundColor: 'white',
    },
    select: {
        width: '100%',
        padding: '0.5rem',
        fontSize: '1rem',
        border: '1px solid var(--dark-gray-color)',
        borderRadius: 'var(--border-radius)',
        backgroundColor: '#fff',
        color: 'var(--text-color)',
    },
    formGroup: {
        marginBottom: '1.5rem',
    },
    label: {
        display: 'block',
        fontWeight: '600',
        marginBottom: '0.5rem',
    },
    description: {
        fontSize: '0.9rem',
        color: 'var(--light-text-color)',
        marginBottom: '0.5rem',
    },
    stepper: {
        display: 'flex',
        justifyContent: 'space-between',
        marginBottom: '2rem',
        // FIX: Cast 'relative' to a specific string literal type to satisfy React.CSSProperties.
        position: 'relative' as 'relative',
    },
    step: {
        display: 'flex',
        // FIX: Cast 'column' to a specific string literal type to satisfy React.CSSProperties.
        flexDirection: 'column' as 'column',
        alignItems: 'center',
        textAlign: 'center' as 'center',
        width: '120px',
    },
    stepNumber: {
        width: '3rem',
        height: '3rem',
        borderRadius: '50%',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        fontWeight: 'bold',
        fontSize: '1.25rem',
        marginBottom: '0.5rem',
        border: '2px solid',
        zIndex: 1,
    },
    stepLine: {
        // FIX: Cast 'absolute' to a specific string literal type to satisfy React.CSSProperties.
        position: 'absolute' as 'absolute',
        top: '1.5rem',
        left: '15%',
        right: '15%',
        height: '2px',
        backgroundColor: 'var(--gray-color)',
        zIndex: 0,
    },
    table: {
        width: '100%',
        // FIX: Cast 'collapse' to a specific string literal type to satisfy React.CSSProperties.
        borderCollapse: 'collapse' as 'collapse',
        marginTop: '1rem',
    },
    th: {
        border: '1px solid var(--gray-color)',
        padding: '0.75rem',
        // FIX: Cast 'left' to a specific string literal type to satisfy React.CSSProperties.
        textAlign: 'left' as 'left',
        backgroundColor: 'var(--light-gray-color)',
        fontWeight: 600,
    },
    td: {
        border: '1px solid var(--gray-color)',
        padding: '0.75rem',
    },
    grid: {
        display: 'grid',
        gridTemplateColumns: '1fr 1fr',
        gap: '1.5rem',
    },
};

// --- COMPONENTS ---

const Stepper = ({ currentStep }) => {
    const steps = ['Maturity Assessment', 'Prioritas Kepentingan', 'Readiness Audit'];
    const activeColor = 'var(--primary-color)';
    const inactiveColor = 'var(--gray-color)';
    const activeTextColor = 'white';
    const inactiveTextColor = 'var(--light-text-color)';

    return (
        <div style={styles.stepper}>
            <div style={styles.stepLine}></div>
            {steps.map((step, index) => {
                const stepIndex = index + 1;
                const isActive = stepIndex <= currentStep;
                return (
                    <div key={step} style={styles.step}>
                        <div style={{
                            ...styles.stepNumber,
                            backgroundColor: isActive ? activeColor : 'white',
                            borderColor: isActive ? activeColor : inactiveColor,
                            color: isActive ? activeTextColor : inactiveColor,
                        }}>
                            {stepIndex}
                        </div>
                        <span style={{ color: isActive ? 'var(--text-color)' : inactiveColor, fontWeight: isActive ? '600' : 'normal' }}>{step}</span>
                    </div>
                );
            })}
        </div>
    );
};

const Welcome = ({ onStart }) => {
    const [companyName, setCompanyName] = useState('');

    return (
        <div className="card">
            <h1 style={{ textAlign: 'center' }}>Evaluasi Sistem Pengelolaan Pelanggan</h1>
            <p style={{ textAlign: 'center', color: 'var(--light-text-color)' }}>Alat bantu untuk UMKM dalam menilai sistem pengelolaan pelanggan secara objektif.</p>
            <div style={styles.formGroup}>
                <label htmlFor="companyName" style={styles.label}>Nama Perusahaan</label>
                <input
                    id="companyName"
                    type="text"
                    value={companyName}
                    onChange={(e) => setCompanyName(e.target.value)}
                    placeholder="Masukkan nama perusahaan Anda"
                    style={styles.input}
                    aria-label="Nama Perusahaan"
                />
            </div>
            <div style={{ display: 'flex', justifyContent: 'center', marginTop: '2rem' }}>
                <button
                    onClick={() => onStart(companyName)}
                    disabled={!companyName}
                    style={{ ...styles.button, ...(companyName ? {} : styles.buttonDisabled) }}
                    aria-disabled={!companyName}
                >
                    Mulai Asesmen
                </button>
            </div>
        </div>
    );
};

const AssessmentWizard = ({ onComplete }) => {
    const [step, setStep] = useState(1);
    const [data, setData] = useState({
        maturity: MATURITY_QUESTIONS.reduce((acc, q) => ({ ...acc, [q.id]: 1 }), {}),
        priority: PRIORITY_ITEMS.reduce((acc, p) => ({ ...acc, [p.id]: '' }), {}),
        readiness: READINESS_QUESTIONS.reduce((acc, q) => ({ ...acc, [q.id]: 3 }), {}),
    });

    const handleUpdate = (form, field, value) => {
        setData(prev => ({
            ...prev,
            [form]: { ...prev[form], [field]: value }
        }));
    };

    const nextStep = () => setStep(s => s + 1);
    const prevStep = () => setStep(s => s - 1);

    // FIX: Explicitly type the accumulator `sum` as a number to prevent type inference issues.
    const priorityTotal = useMemo(() => Object.values(data.priority).reduce((sum: number, val) => sum + (Number(val) || 0), 0), [data.priority]);

    const priorityErrors = useMemo(() => {
        const errors = {};
        for (const key in data.priority) {
            const value = data.priority[key];
            if (value !== '' && Number(value) % 5 !== 0) {
                errors[key] = true;
            }
        }
        return errors;
    }, [data.priority]);
    const hasPriorityErrors = Object.keys(priorityErrors).length > 0;

    const renderStep = () => {
        switch (step) {
            case 1:
                return (
                    <>
                        <h2 style={{ marginTop: 0 }}>Asesmen Maturitas</h2>
                        <p style={styles.description}>Pada tahap ini, pilih kondisi sistem manajemen pelanggan yang paling sesuai dengan perusahaan anda.</p>
                        {MATURITY_QUESTIONS.map(q => (
                            <div key={q.id} style={styles.formGroup}>
                                <label style={styles.label}>{q.label}</label>
                                <p style={styles.description}>{q.description}</p>
                                <select value={data.maturity[q.id]} onChange={e => handleUpdate('maturity', q.id, Number(e.target.value))} style={styles.select}>
                                    {q.options.map(opt => <option key={opt.value} value={opt.value}>{opt.text}</option>)}
                                </select>
                            </div>
                        ))}
                        <div style={styles.buttonContainer}>
                            <div></div>
                            <button onClick={nextStep} style={styles.button}>Selanjutnya</button>
                        </div>
                    </>
                );
            case 2:
                return (
                    <>
                        <h2 style={{ marginTop: 0 }}>Asesmen Prioritas Kepentingan</h2>
                        <p style={styles.description}>Silahkan melakukan pembobotan kelipatan 5 hingga total seluruh komponen sama dengan 100.</p>
                        <div style={{ position: 'sticky', top: '1rem', backgroundColor: '#fff', padding: '1rem', border: '1px solid var(--gray-color)', borderRadius: 'var(--border-radius)', zIndex: 10, display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1rem' }}>
                            <h3 style={{ margin: 0 }}>Total Bobot</h3>
                            <span style={{ fontSize: '1.5rem', fontWeight: 'bold', color: priorityTotal === 100 && !hasPriorityErrors ? 'green' : 'red' }}>{priorityTotal} / 100</span>
                        </div>
                        {PRIORITY_ITEMS.map(p => (
                            <div key={p.id} style={styles.formGroup}>
                                <label style={styles.label}>{p.label}</label>
                                <p style={styles.description}>{p.description}</p>
                                <input
                                    type="number"
                                    min="0"
                                    max="100"
                                    value={data.priority[p.id]}
                                    onChange={e => handleUpdate('priority', p.id, e.target.value)}
                                    style={{ ...styles.input, ...(priorityErrors[p.id] ? { borderColor: 'red' } : {}) }}
                                    placeholder="Kelipatan 5"
                                />
                                {priorityErrors[p.id] && <p style={{ color: 'red', fontSize: '0.8rem', marginTop: '0.25rem' }}>Input harus kelipatan 5.</p>}
                            </div>
                        ))}
                        <div style={styles.buttonContainer}>
                            <button onClick={prevStep} style={{ ...styles.button, ...styles.secondaryButton }}>Kembali</button>
                            <button onClick={nextStep} disabled={priorityTotal !== 100 || hasPriorityErrors} style={{ ...styles.button, ...(priorityTotal === 100 && !hasPriorityErrors ? {} : styles.buttonDisabled) }}>Selanjutnya</button>
                        </div>
                    </>
                );
            case 3:
                return (
                    <>
                        <h2 style={{ marginTop: 0 }}>Audit Sistem Pengelolaan Pelanggan</h2>
                        <p style={styles.description}>Pada tahap ini, pilih kondisi sistem manajemen pelanggan yang paling sesuai dengan perusahaan anda.</p>
                        {READINESS_QUESTIONS.map(q => (
                            <div key={q.id} style={styles.formGroup}>
                                <label style={styles.label}>{q.label}</label>
                                <select value={data.readiness[q.id]} onChange={e => handleUpdate('readiness', q.id, Number(e.target.value))} style={styles.select}>
                                    {q.options.map(opt => <option key={opt.value} value={opt.value}>{opt.text}</option>)}
                                </select>
                            </div>
                        ))}
                        <div style={styles.buttonContainer}>
                            <button onClick={prevStep} style={{ ...styles.button, ...styles.secondaryButton }}>Kembali</button>
                            <button onClick={() => onComplete(data)} style={styles.button}>Lihat Hasil</button>
                        </div>
                    </>
                );
            default: return null;
        }
    }

    return (
        <div className="card">
            <Stepper currentStep={step} />
            {renderStep()}
        </div>
    );
};

const IPAGraph = ({ data }) => {
    const width = 450, height = 300, padding = 40;
    const xMax = 25, yMax = 100;
    const xMid = 12.5, yMid = 70;

    const scaleX = val => (val / xMax) * (width - padding * 2) + padding;
    const scaleY = val => height - padding - (val / yMax) * (height - padding * 2);

    const processedData = useMemo(() => {
        const positionMap = new Map();
        data.forEach(point => {
            const key = `${point.importance}-${point.performance}`;
            if (!positionMap.has(key)) {
                positionMap.set(key, []);
            }
            positionMap.get(key).push(point);
        });

        const finalPoints = [];
        positionMap.forEach(points => {
            if (points.length === 1) {
                finalPoints.push({ ...points[0], yOffset: 4 }); // Default single point y offset
            } else {
                // Handle overlapping points
                const totalPoints = points.length;
                const baseOffsetY = 4;
                const spread = 12; // vertical distance between labels
                const initialOffset = -((totalPoints - 1) * spread) / 2;

                points.forEach((point, index) => {
                    finalPoints.push({
                        ...point,
                        yOffset: baseOffsetY + initialOffset + index * spread,
                    });
                });
            }
        });
        return finalPoints;
    }, [data]);

    const xTicks = [0, 5, 10, 15, 20, 25];
    const yTicks = [0, 20, 40, 60, 80, 100];

    return (
        <svg width="100%" viewBox={`0 0 ${width} ${height}`} aria-labelledby="ipa-title" role="img">
            <title id="ipa-title">Importance-Performance Analysis Graph</title>

            {/* Quadrant backgrounds and labels */}
            <rect x={scaleX(xMid)} y={padding} width={scaleX(xMax) - scaleX(xMid)} height={scaleY(yMid) - padding} fill="#f0f9ff" />
            <rect x={padding} y={padding} width={scaleX(xMid) - padding} height={scaleY(yMid) - padding} fill="#f0fff0" />
            <rect x={padding} y={scaleY(yMid)} width={scaleX(xMid) - padding} height={scaleY(0) - scaleY(yMid)} fill="#fffbe6" />
            <rect x={scaleX(xMid)} y={scaleY(yMid)} width={scaleX(xMax) - scaleX(xMid)} height={scaleY(0) - scaleY(yMid)} fill="#fff0f0" />

            <g fontSize="10" fill="var(--light-text-color)" textAnchor="middle" style={{ opacity: 0.7 }}>
                <text x={scaleX(xMid + (xMax - xMid) / 2)} y={padding + 15}>Keep Up The Good Work</text>
                <text x={scaleX(xMid / 2)} y={padding + 15}>Possible Overkill</text>
                <text x={scaleX(xMid / 2)} y={height - padding - 10}>Low Priority</text>
                <text x={scaleX(xMid + (xMax - xMid) / 2)} y={height - padding - 10}>Concentrate Here</text>
            </g>

            {/* Axes */}
            <line x1={padding} y1={height - padding} x2={width - padding} y2={height - padding} stroke="var(--gray-color)" />
            <line x1={padding} y1={padding} x2={padding} y2={height - padding} stroke="var(--gray-color)" />
            <text x={width / 2} y={height - 5} textAnchor="middle" fontSize="12" fill="var(--light-text-color)">Importance</text>
            <text x={10} y={height / 2} transform={`rotate(-90, 10, ${height / 2})`} textAnchor="middle" fontSize="12" fill="var(--light-text-color)">Performance</text>

            {/* Mid lines */}
            <line x1={scaleX(xMid)} y1={padding} x2={scaleX(xMid)} y2={height - padding} stroke="var(--gray-color)" strokeDasharray="4" />
            <line x1={padding} y1={scaleY(yMid)} x2={width - padding} y2={scaleY(yMid)} stroke="var(--gray-color)" strokeDasharray="4" />

            {/* Axis Ticks */}
            <g className="axis-ticks">
                {xTicks.map(tick => (
                    <g key={`x-tick-${tick}`} transform={`translate(${scaleX(tick)}, ${height - padding})`}>
                        <line y2="5" stroke="var(--gray-color)" />
                        <text y="15" textAnchor="middle" fontSize="10" fill="var(--light-text-color)">{tick}</text>
                    </g>
                ))}
                {yTicks.map(tick => (
                    <g key={`y-tick-${tick}`} transform={`translate(${padding}, ${scaleY(tick)})`}>
                        <line x2="-5" stroke="var(--gray-color)" />
                        <text x="-8" y="3" textAnchor="end" fontSize="10" fill="var(--light-text-color)">{tick}</text>
                    </g>
                ))}
            </g>

            {/* Data Points */}
            {processedData.map(d => (
                <g key={d.id}>
                    <circle cx={scaleX(d.importance)} cy={scaleY(d.performance)} r="5" fill="var(--primary-color)" />
                    <text x={scaleX(d.importance) + 8} y={scaleY(d.performance) + d.yOffset} fontSize="10" fill="var(--text-color)">
                        {d.label}
                    </text>
                </g>
            ))}
        </svg>
    );
};

const Dashboard = ({ companyName, data, onReset }) => {
    const results = useMemo(() => {
        // Maturity
        const maturityScores = Object.values(data.maturity);
        const maturityAverage = maturityScores.reduce((sum: number, val) => sum + Number(val), 0) / maturityScores.length;

        const roundedAvg = Math.round(maturityAverage);
        const insightIndex = Math.max(0, Math.min(4, roundedAvg - 1));
        const maturityInsightData = MATURITY_INSIGHTS[insightIndex];

        // Readiness & Performance
        const performanceData = PRIORITY_ITEMS.map(item => {
            const readinessQuestion = READINESS_QUESTIONS.find(q => q.target === item.id);
            const score = readinessQuestion ? data.readiness[readinessQuestion.id] : 3;
            const performance = (score / 5) * 100;
            return {
                id: item.id,
                label: item.label,
                importance: Number(data.priority[item.id]),
                performance,
            };
        });

        // Process Groups
        // FIX: Using JSON.parse returns `any`. Casting the result ensures type safety downstream.
        const processGroupResults = JSON.parse(JSON.stringify(PROCESS_GROUPS)) as typeof PROCESS_GROUPS;
        for (const groupKey in processGroupResults) {
            const group = processGroupResults[groupKey];
            const groupItems = group.items;
            const totalPerf = groupItems.reduce((sum: number, itemId) => {
                const itemPerf = performanceData.find(p => p.id === itemId)?.performance || 0;
                return sum + itemPerf;
            }, 0);
            group.performance = groupItems.length > 0 ? Math.round(totalPerf / groupItems.length) : 0;
        }

        // Overall Score
        const totalWeightedPerformance = performanceData.reduce((sum, item) => sum + (item.performance * item.importance), 0);
        const totalWeight = performanceData.reduce((sum, item) => sum + item.importance, 0);
        const overallScore = totalWeight > 0 ? Math.round(totalWeightedPerformance / totalWeight) : 0;

        // Recommendation
        const processGroupPerformances = Object.entries(processGroupResults).map(([key, group]) => ({
            key,
            performance: group.performance
        }));

        let recommendation = 'Secara umum, pertahankan kinerja yang sudah baik dan terus lakukan perbaikan berkelanjutan.';
        if (processGroupPerformances.length > 0) {
            const lowestPerfGroup = processGroupPerformances.reduce((min, current) => current.performance < min.performance ? current : min);
            // FIX: The `lowestPerfGroup.key` is of type `string`, which cannot safely index `RECOMMENDATIONS`.
            // A type assertion is used to ensure type safety.
            recommendation = RECOMMENDATIONS[lowestPerfGroup.key as keyof typeof RECOMMENDATIONS];
        }


        return { maturityAverage, maturityInsightData, performanceData, processGroupResults, overallScore, recommendation };
    }, [data]);

    return (
        <>
            <div className="card">
                <h1>Dashboard Hasil Evaluasi</h1>
                <h2>{companyName}</h2>
                <button onClick={onReset} style={{ ...styles.button, ...styles.secondaryButton }}>Mulai Asesmen Baru</button>
            </div>
            <div className="card">
                <h3>Maturity Assessment</h3>
                <div style={styles.grid}>
                    <div>
                        <table style={styles.table}>
                            <thead><tr><th style={styles.th}>Komponen</th><th style={styles.th}>Nilai</th></tr></thead>
                            <tbody>
                                {MATURITY_QUESTIONS.map(q => (
                                    <tr key={q.id}>
                                        <td style={styles.td}>{q.label}</td>
                                        <td style={styles.td}>{data.maturity[q.id]}</td>
                                    </tr>
                                ))}
                                <tr>
                                    <td style={{ ...styles.td, fontWeight: 'bold' }}>Average</td>
                                    <td style={{ ...styles.td, fontWeight: 'bold' }}>{results.maturityAverage.toFixed(2)}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h4>Insights Gained</h4>
                        <h5 style={{ marginTop: 0, marginBottom: '0.5rem' }}>{results.maturityInsightData.title}</h5>
                        <p style={{ whiteSpace: 'pre-wrap' }}>{results.maturityInsightData.description}</p>
                    </div>
                </div>
            </div>
            <div className="card">
                <h3>Readiness Audit</h3>
                <div style={styles.grid}>
                    <div>
                        <table style={styles.table}>
                            <thead><tr><th style={styles.th}>Bobot Kepentingan</th><th style={styles.th}>Bobot</th><th style={styles.th}>Performansi</th></tr></thead>
                            <tbody>
                                {results.performanceData.map(p => (
                                    <tr key={p.id}>
                                        <td style={styles.td}>{p.label}</td>
                                        <td style={styles.td}>{p.importance}</td>
                                        <td style={styles.td}>{p.performance.toFixed(0)}%</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h4>Importance - Performance Analysis</h4>
                        <IPAGraph data={results.performanceData.map(d => ({ ...d, label: PRIORITY_ITEMS.find(p => p.id === d.id).label.split(' ')[0] }))} />
                    </div>
                </div>
            </div>
            <div className="card">
                <h3>Performance Assessment</h3>
                <div style={styles.grid}>
                    <div>
                        <table style={styles.table}>
                            <thead><tr><th style={styles.th}>Proses Sistem Pengelolaan Pelanggan</th><th style={styles.th}>Performansi</th></tr></thead>
                            <tbody>
                                {/* FIX: Explicitly typing `group` ensures that its properties are correctly typed, preventing 'unknown' from being assigned to ReactNode. */}
                                {Object.values(results.processGroupResults).map((group: ProcessGroup) => (
                                    <tr key={group.name}>
                                        <td style={styles.td}>{group.name}</td>
                                        <td style={styles.td}>{group.performance}%</td>
                                    </tr>

                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center', backgroundColor: 'var(--light-gray-color)', borderRadius: 'var(--border-radius)' }}>
                        <h4>Nilai Sistem Pengelolaan Pelanggan</h4>
                        <h1 style={{ fontSize: '4rem', color: 'var(--primary-color)', margin: 0 }}>{results.overallScore}</h1>
                    </div>
                </div>
                <div style={{ marginTop: '2rem', borderTop: '1px solid var(--gray-color)', paddingTop: '1.5rem' }}>
                    <h4>Rekomendasi</h4>
                    <p style={{ whiteSpace: 'pre-wrap' }}>{results.recommendation}</p>
                </div>
            </div>
        </>
    );
};

const App = () => {
    const [page, setPage] = useState('welcome'); // welcome, assessment, dashboard
    const [companyName, setCompanyName] = useState('');
    const [assessmentData, setAssessmentData] = useState(null);

    const handleStart = (name) => {
        setCompanyName(name);
        setPage('assessment');
    };

    const handleComplete = (data) => {
        setAssessmentData(data);
        setPage('dashboard');
    }

    const handleReset = () => {
        setPage('welcome');
        setCompanyName('');
        setAssessmentData(null);
    }

    const renderPage = () => {
        switch (page) {
            case 'assessment':
                return <AssessmentWizard onComplete={handleComplete} />;
            case 'dashboard':
                return <Dashboard companyName={companyName} data={assessmentData} onReset={handleReset} />;
            case 'welcome':
            default:
                return <Welcome onStart={handleStart} />;
        }
    };

    return <main>{renderPage()}</main>;
};

const container = document.getElementById('root');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}