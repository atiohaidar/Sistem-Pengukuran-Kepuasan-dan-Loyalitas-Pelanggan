Baik, saya pahami! Mari kita buat rencana detail berdasarkan klarifikasi Anda. Ini lebih sederhana dan fokus.

## 📋 Rencana Detail Implementasi

### 🗄️ **1. Database Structure**

#### Tabel: `survey_campaigns`
```sql
CREATE TABLE survey_campaigns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    umkm_id BIGINT UNSIGNED NOT NULL,  -- FK ke users (yang role umkm)
    type ENUM('produk', 'pelatihan') NOT NULL,
    name VARCHAR(255) NOT NULL,  -- "Pelatihan Digital Marketing Batch 2"
    slug VARCHAR(255) NOT NULL UNIQUE,  -- "pelatihan-digital-marketing-batch-2"
    description TEXT,
    max_respondents INT UNSIGNED NULL,  -- NULL = unlimited
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status ENUM('draft', 'active', 'closed', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (umkm_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_slug (slug),
    INDEX idx_umkm_type (umkm_id, type),
    INDEX idx_status (status)
);
```

#### Update Tabel Existing (Opsi A):
```sql
-- produk_survey_responses
ALTER TABLE produk_survey_responses 
ADD COLUMN survey_campaign_id BIGINT UNSIGNED NULL AFTER id,
ADD FOREIGN KEY (survey_campaign_id) REFERENCES survey_campaigns(id) ON DELETE CASCADE;

-- pelatihan_survey_responses  
ALTER TABLE pelatihan_survey_responses
ADD COLUMN survey_campaign_id BIGINT UNSIGNED NULL AFTER id,
ADD FOREIGN KEY (survey_campaign_id) REFERENCES survey_campaigns(id) ON DELETE CASCADE;
```

**Note**: `survey_campaign_id` nullable untuk backward compatibility dengan data lama (yang akan dihapus).

---

### 🎯 **2. Routes Planning**

```php
// routes/web.php

// UMKM - Survey Campaign Management (authenticated)
Route::middleware(['auth', 'role:umkm'])->prefix('survey-campaigns')->name('survey-campaigns.')->group(function() {
    
    // List & CRUD
    Route::get('/', [SurveyCampaignController::class, 'index'])->name('index');
    Route::get('/create', [SurveyCampaignController::class, 'create'])->name('create');
    Route::post('/', [SurveyCampaignController::class, 'store'])->name('store');
    Route::get('/{campaign}/edit', [SurveyCampaignController::class, 'edit'])->name('edit');
    Route::put('/{campaign}', [SurveyCampaignController::class, 'update'])->name('update');
    Route::delete('/{campaign}', [SurveyCampaignController::class, 'destroy'])->name('destroy');
    
    // Dashboard & Analytics per Campaign
    Route::get('/{campaign}/dashboard', [SurveyCampaignController::class, 'dashboard'])->name('dashboard');
    
    // Responses Management
    Route::get('/{campaign}/responses', [SurveyCampaignController::class, 'responses'])->name('responses');
    Route::get('/{campaign}/responses/{response}', [SurveyCampaignController::class, 'responseDetail'])->name('responses.detail');
    Route::get('/{campaign}/export', [SurveyCampaignController::class, 'export'])->name('export');
    
    // Status Management
    Route::post('/{campaign}/activate', [SurveyCampaignController::class, 'activate'])->name('activate');
    Route::post('/{campaign}/close', [SurveyCampaignController::class, 'close'])->name('close');
    Route::post('/{campaign}/archive', [SurveyCampaignController::class, 'archive'])->name('archive');
    
    // Duplicate Campaign (bonus feature)
    Route::post('/{campaign}/duplicate', [SurveyCampaignController::class, 'duplicate'])->name('duplicate');
});

// Public Survey Routes (NO AUTH REQUIRED)
Route::prefix('survey')->name('public-survey.')->group(function() {
    Route::get('/{slug}', [PublicSurveyController::class, 'show'])->name('show');
    Route::post('/{slug}/submit', [PublicSurveyController::class, 'submit'])->name('submit');
    Route::get('/{slug}/thank-you', [PublicSurveyController::class, 'thankYou'])->name('thank-you');
});
```

---

### 📁 **3. File Structure**

```
app/
├── Http/
│   └── Controllers/
│       ├── SurveyCampaignController.php (NEW) - Manajemen kampanye untuk UMKM
│       └── PublicSurveyController.php (NEW) - Form survei publik
│
├── Models/
│   ├── SurveyCampaign.php (NEW)
│   ├── ProdukSurveyResponse.php (UPDATE - add relationship)
│   └── PelatihanSurveyResponse.php (UPDATE - add relationship)
│
├── Services/
│   ├── SurveyCampaignService.php (NEW) - Business logic kampanye
│   └── SurveyCalculationService.php (UPDATE - add per campaign calculation)
│
└── Exports/
    └── SurveyCampaignResponsesExport.php (NEW) - Export per kampanye

database/
└── migrations/
    ├── 2025_10_28_000001_create_survey_campaigns_table.php (NEW)
    ├── 2025_10_28_000002_add_campaign_id_to_produk_survey_responses.php (NEW)
    ├── 2025_10_28_000003_add_campaign_id_to_pelatihan_survey_responses.php (NEW)
    └── 2025_10_28_000004_cleanup_old_survey_responses.php (NEW) - Hapus data lama

resources/views/
├── survey-campaigns/ (NEW)
│   ├── index.blade.php - List kampanye
│   ├── create.blade.php - Form buat kampanye
│   ├── edit.blade.php - Form edit kampanye
│   ├── dashboard.blade.php - Dashboard per kampanye
│   ├── responses.blade.php - List responses per kampanye
│   └── response-detail.blade.php - Detail satu response
│
└── public-survey/ (NEW)
    ├── show.blade.php - Form survei publik
    ├── closed.blade.php - Survei sudah ditutup
    └── thank-you.blade.php - Terima kasih setelah submit
```

---

### 🔄 **4. Detailed Feature Flow**

#### **A. UMKM - Membuat Kampanye Survei**

**Page**: `/survey-campaigns/create`

**Form Fields**:
```
1. Jenis Survei: [ Radio: Produk / Pelatihan ] *required
2. Nama Kegiatan: [ Input text ] *required
   - Contoh: "Pelatihan Digital Marketing Batch 2"
   - Max 255 karakter
   
3. Slug URL: [ Input text dengan auto-generate ] *required, unique
   - Auto-generate dari nama (kebab-case)
   - Bisa diedit manual oleh UMKM
   - Preview URL: surveyapp.com/survey/{slug}
   - Validasi: hanya huruf, angka, dan dash
   
4. Deskripsi: [ Textarea ]
   - Opsional
   - Max 1000 karakter
   
5. Periode Survei:
   - Tanggal Mulai: [ DateTime picker ] *required
   - Tanggal Selesai: [ DateTime picker ] *required
   - Validasi: end_date > start_date
   
6. Maksimal Responden: [ Input number ]
   - Opsional (kosongkan untuk unlimited)
   - Min: 1 jika diisi
   - Info: "Kosongkan jika tidak ada batasan"
   
7. Status Awal: [ Select: Draft / Aktif ]
   - Default: Draft
   - Info: "Draft = belum bisa diakses publik"
```

**Auto-slug Logic**:
```php
// JavaScript real-time
Input "Nama" onChange -> auto generate slug
"Pelatihan Digital Marketing 2024" -> "pelatihan-digital-marketing-2024"

// PHP validation (jika slug sudah ada)
"pelatihan-digital-marketing-2024" exists
-> suggest "pelatihan-digital-marketing-2024-2"
```

**Validations**:
- Slug unique check
- Date range valid
- Max respondents > 0 if set
- User must be UMKM role

---

#### **B. UMKM - List Kampanye Survei**

**Page**: `/survey-campaigns`

**Layout**:
```
Header:
├── Title: "Manajemen Survei Kepuasan"
├── Button: "+ Buat Survei Baru"
└── Stats Cards:
    ├── Total Kampanye
    ├── Aktif
    ├── Selesai
    └── Total Responden (semua kampanye)

Filter & Search:
├── Search: nama kampanye
├── Filter Jenis: Semua / Produk / Pelatihan
├── Filter Status: Semua / Draft / Aktif / Closed / Archived
└── Sort: Terbaru / Terlama / Nama A-Z

Table Columns:
├── Nama Kampanye (link ke dashboard)
├── Jenis (badge: Produk/Pelatihan)
├── Status (badge dengan warna)
├── Periode (start - end)
├── Responden (current/max atau current jika unlimited)
├── Progress Bar
└── Aksi:
    ├── View Dashboard
    ├── Copy Link
    ├── Edit
    ├── Responses
    ├── Export
    ├── Status Actions (Activate/Close/Archive)
    └── Delete (dengan konfirmasi)
```

**Status Badge Colors**:
- Draft: Gray
- Active: Green
- Closed: Red
- Archived: Blue

---

#### **C. UMKM - Dashboard Per Kampanye**

**Page**: `/survey-campaigns/{campaign}/dashboard`

**Layout**:
```
Header:
├── Campaign Name + Description
├── UMKM Info
├── Public Link dengan Copy Button
│   └── URL: https://yourapp.com/survey/{slug}
├── QR Code (generate on-the-fly)
└── Status Badge

Info Cards (4 columns):
├── Total Responden
│   ├── Number: 45
│   └── Subtext: "dari 100 target" atau "unlimited"
├── Completion Rate
│   ├── Percentage: 89%
│   └── Subtext: "responden menyelesaikan"
├── Periode Survei
│   ├── Date Range
│   └── "X hari tersisa" atau "Selesai"
└── Rata-rata Waktu Pengisian
    └── "3 menit 24 detik"

Chart Section:
├── [Grafik yang sama seperti dashboard lama, tapi filtered per campaign]
│   ├── Distribusi Skor Kepuasan
│   ├── Distribusi Skor Loyalitas
│   ├── Dimensi Kualitas
│   └── dll (sesuai type: produk/pelatihan)
│
└── Tren Responses Over Time (Line Chart)
    └── X-axis: Tanggal, Y-axis: Jumlah responses

Recent Responses Table:
├── 10 responses terbaru
├── Columns: Nama, Email, Tanggal, Skor, Action (View Detail)
└── Button: "Lihat Semua Responses"

Action Buttons:
├── Export to Excel
├── Edit Kampanye
├── Close Survey (jika aktif)
└── Archive (jika closed)
```

---

#### **D. Public - Mengisi Survei**

**Page**: `/survey/{slug}`

**Flow**:

1. **Validasi Awal**:
```php
Check:
- Campaign exists?
- Status = 'active'?
- Current date between start_date and end_date?
- Max respondents not reached (if set)?

If fail -> redirect to "Survey Closed" page
```

2. **Landing Section** (sebelum form):
```
Card Header:
├── UMKM Logo/Name
├── Campaign Name (large)
├── Campaign Type Badge (Produk/Pelatihan)
├── Description
└── Info:
    ├── "Survei ini diselenggarakan oleh: [UMKM Name]"
    ├── "Waktu pengisian: ~5 menit"
    └── "Periode: [start] - [end]"

Button: "Mulai Mengisi Survei"
```

3. **Form Survei** (sama dengan form existing):
```
- Pertanyaan yang sama untuk produk/pelatihan
- Progress bar
- Navigation: Previous/Next
- Submit button di akhir
```

4. **Submit Logic**:
```php
// Store to appropriate table based on campaign type
if ($campaign->type === 'produk') {
    ProdukSurveyResponse::create([
        'survey_campaign_id' => $campaign->id,
        // ... other fields
    ]);
} else {
    PelatihanSurveyResponse::create([
        'survey_campaign_id' => $campaign->id,
        // ... other fields
    ]);
}

// Check if reached max_respondents
if ($campaign->max_respondents) {
    $totalResponses = $campaign->responses()->count();
    if ($totalResponses >= $campaign->max_respondents) {
        $campaign->update(['status' => 'closed']);
    }
}
```

5. **Thank You Page**: `/survey/{slug}/thank-you`
```
Success message:
├── Icon: ✓
├── "Terima kasih telah mengisi survei!"
├── Campaign name
├── UMKM name
└── Button: "Kembali ke Beranda" atau custom URL
```

---

#### **E. Survey Closed Page**

**Page**: `/survey/{slug}` (when validation fails)

**Scenarios & Messages**:
```
1. Status bukan 'active':
   "Survei ini belum/sudah tidak aktif"
   
2. Belum dimulai (current < start_date):
   "Survei ini akan dibuka pada: [start_date]"
   
3. Sudah berakhir (current > end_date):
   "Survei ini telah berakhir pada: [end_date]"
   
4. Responden penuh:
   "Survei ini sudah mencapai batas maksimal responden"
   
Info:
├── Campaign name
├── UMKM info
└── Contact/support info (optional)
```

---

### 🔧 **5. Model Relationships**

```php
// app/Models/SurveyCampaign.php
class SurveyCampaign extends Model
{
    protected $fillable = [
        'umkm_id', 'type', 'name', 'slug', 'description',
        'max_respondents', 'start_date', 'end_date', 'status'
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    
    // Relationships
    public function umkm() {
        return $this->belongsTo(User::class, 'umkm_id');
    }
    
    public function responses() {
        // Dynamic based on type
        if ($this->type === 'produk') {
            return $this->hasMany(ProdukSurveyResponse::class, 'survey_campaign_id');
        }
        return $this->hasMany(PelatihanSurveyResponse::class, 'survey_campaign_id');
    }
    
    // Scopes
    public function scopeActive($query) {
        return $query->where('status', 'active');
    }
    
    public function scopeByUmkm($query, $umkmId) {
        return $query->where('umkm_id', $umkmId);
    }
    
    // Accessors
    public function getPublicUrlAttribute() {
        return route('public-survey.show', $this->slug);
    }
    
    public function getIsActiveAttribute() {
        return $this->status === 'active' 
            && now()->between($this->start_date, $this->end_date);
    }
    
    public function getResponsesCountAttribute() {
        return $this->responses()->count();
    }
    
    public function getProgressPercentageAttribute() {
        if (!$this->max_respondents) return null;
        return min(100, ($this->responses_count / $this->max_respondents) * 100);
    }
    
    public function getIsFullAttribute() {
        if (!$this->max_respondents) return false;
        return $this->responses_count >= $this->max_respondents;
    }
    
    // Methods
    public function canAcceptResponses() {
        return $this->is_active 
            && !$this->is_full 
            && now()->lte($this->end_date);
    }
    
    public function autoCloseIfFull() {
        if ($this->is_full && $this->status === 'active') {
            $this->update(['status' => 'closed']);
        }
    }
}
```

```php
// app/Models/ProdukSurveyResponse.php (UPDATE)
class ProdukSurveyResponse extends Model
{
    protected $fillable = [
        'survey_campaign_id', // NEW
        // ... existing fields
    ];
    
    public function campaign() { // NEW
        return $this->belongsTo(SurveyCampaign::class, 'survey_campaign_id');
    }
}

// Same for PelatihanSurveyResponse
```

---

### 🎨 **6. UI/UX Details**

#### **Color Scheme untuk Status**:
```css
.badge-draft { @apply bg-gray-100 text-gray-800; }
.badge-active { @apply bg-green-100 text-green-800; }
.badge-closed { @apply bg-red-100 text-red-800; }
.badge-archived { @apply bg-blue-100 text-blue-800; }

.badge-produk { @apply bg-purple-100 text-purple-800; }
.badge-pelatihan { @apply bg-indigo-100 text-indigo-800; }
```

#### **Icons** (Font Awesome):
```
Produk: fa-box
Pelatihan: fa-graduation-cap
Active: fa-check-circle
Closed: fa-times-circle
Copy Link: fa-copy
QR Code: fa-qrcode
Export: fa-download
Dashboard: fa-chart-bar
Responses: fa-users
Edit: fa-edit
Delete: fa-trash
```

#### **Progress Bar**:
```html
<div class="w-full bg-gray-200 rounded-full h-2">
    <div class="bg-green-600 h-2 rounded-full" 
         style="width: {{ $campaign->progress_percentage }}%">
    </div>
</div>
<span class="text-sm text-gray-600">
    {{ $campaign->responses_count }} 
    @if($campaign->max_respondents)
        / {{ $campaign->max_respondents }}
    @endif
</span>
```

---

### ⚙️ **7. Business Logic Highlights**

#### **Auto-slug Generation**:
```php
// SurveyCampaignService.php
public function generateSlug($name, $excludeId = null) {
    $slug = Str::slug($name);
    $originalSlug = $slug;
    $counter = 1;
    
    while (SurveyCampaign::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }
    
    return $slug;
}
```

#### **Validation Rules**:
```php
// Store/Update
'name' => 'required|max:255',
'slug' => 'required|alpha_dash|max:255|unique:survey_campaigns,slug,' . $id,
'type' => 'required|in:produk,pelatihan',
'description' => 'nullable|max:1000',
'start_date' => 'required|date',
'end_date' => 'required|date|after:start_date',
'max_respondents' => 'nullable|integer|min:1',
'status' => 'required|in:draft,active,closed,archived',
```

#### **Auto-close Logic**:
```php
// Run via scheduler atau setiap response submit
public function checkAndCloseExpired() {
    SurveyCampaign::active()
        ->where('end_date', '<', now())
        ->update(['status' => 'closed']);
}

// Or in PublicSurveyController after submit
$campaign->autoCloseIfFull();
```

---

### 📊 **8. Dashboard Calculation Updates**

**Service**: `SurveyCalculationService.php`

**Update Method**:
```php
// FROM:
public function calculateProdukResults() {
    $responses = ProdukSurveyResponse::all();
    // ...
}

// TO:
public function calculateProdukResults($campaignId = null) {
    $query = ProdukSurveyResponse::query();
    
    if ($campaignId) {
        $query->where('survey_campaign_id', $campaignId);
    }
    
    $responses = $query->get();
    // ... rest of calculation
}
```

**Dashboard Controller**:
```php
public function dashboard(SurveyCampaign $campaign) {
    $results = $this->calculationService->calculateResults(
        $campaign->type, 
        $campaign->id
    );
    
    return view('survey-campaigns.dashboard', [
        'campaign' => $campaign,
        'results' => $results,
        'recentResponses' => $campaign->responses()->latest()->limit(10)->get()
    ]);
}
```

---

### 🗑️ **9. Data Cleanup Strategy**

**Migration**: `2025_10_28_000004_cleanup_old_survey_responses.php`

```php
public function up() {
    // Hapus semua response lama yang tidak ada campaign_id
    DB::table('produk_survey_responses')
        ->whereNull('survey_campaign_id')
        ->delete();
        
    DB::table('pelatihan_survey_responses')
        ->whereNull('survey_campaign_id')
        ->delete();
}
```

**Alternative** (jika ingin simpan sebagai arsip):
```php
// Buat satu campaign "Legacy Data" untuk setiap UMKM
// Pindahkan data lama ke campaign tersebut
```

---

### 📝 **10. Migration Order**

```
1. create_survey_campaigns_table
2. add_campaign_id_to_produk_survey_responses
3. add_campaign_id_to_pelatihan_survey_responses  
4. cleanup_old_survey_responses (DESTRUCTIVE)
```

---

### ✅ **11. Testing Checklist**

```
UMKM Flow:
□ Buat kampanye baru (draft)
□ Auto-slug generation works
□ Manual slug edit works
□ Slug unique validation
□ Date validation (end > start)
□ List kampanye dengan filter
□ Edit kampanye
□ Activate kampanye
□ Copy public link
□ View dashboard (empty state)
□ Delete kampanye (dengan konfirmasi)

Public Flow:
□ Access active campaign via slug
□ See campaign info correctly
□ Fill survey form
□ Submit successfully
□ See thank you page
□ Try access closed survey (validations)
□ Multiple submissions work

Auto-close:
□ Survey closes when max_respondents reached
□ Survey closes when end_date passed (via scheduler)
□ Closed survey shows correct message

Dashboard:
□ Stats calculate correctly
□ Charts filtered by campaign
□ Export works per campaign
□ Recent responses show
```

---

## 📦 **Summary Rencana**

### Yang Dihapus dari Rencana Awal:
- ✅ Token system (tidak perlu)
- ✅ Notifikasi email
- ✅ Agregat dashboard (fokus per kampanye)
- ✅ Data lama (akan dihapus)

### Yang Ditambahkan:
- ✅ Auto-slug generation dengan editable option
- ✅ Unlimited respondents by default
- ✅ Auto-close saat max respondents tercapai
- ✅ Progress bar & stats per campaign
- ✅ Public link yang simple (/survey/{slug})

### Core Features:
1. UMKM bisa membuat multiple campaign
2. Setiap campaign punya URL unik (slug-based)
3. Public bisa isi tanpa auth, multiple times
4. Dashboard & analytics per campaign
5. Auto-close saat batas tercapai atau expired

---

**Apakah rencana ini sudah sesuai? Ada yang perlu disesuaikan lagi sebelum eksekusi?** 🚀