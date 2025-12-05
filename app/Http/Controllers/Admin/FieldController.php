<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field; // Menggunakan Model Field
use App\Models\FieldFacility;
use App\Models\FieldGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    /**
     * Menampilkan daftar lapangan.
     */
    public function index()
    {
        // Mengambil semua data dari tabel 'fields'
        $fields = Field::all();
        // Mengarahkan ke view admin.fields.index
        return view('admin.fields.index', compact('fields'));
    }

    // app/Http/Controllers/Admin/FieldController.php

    public function show(Field $field)
    {
        // 1. Load Relasi (Galeri & Fasilitas)
        $field->load(['galleries', 'facilities']);

        // 2. Hitung Statistik Khusus Lapangan Ini
        $totalBookings = $field->reservations()->count();

        // Pendapatan (Hanya status Paid & Confirmed)
        $totalRevenue = $field->reservations()
            ->whereIn('status', ['paid', 'confirmed'])
            ->sum('total_price');

        // Booking yang akan datang (Upcoming)
        $upcomingBookings = $field->reservations()
            ->with('user')
            ->where('booking_date', '>=', now())
            ->whereIn('status', ['paid', 'confirmed', 'pending'])
            ->orderBy('booking_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->take(5) // Ambil 5 jadwal terdekat
            ->get();

        return view('admin.fields.show', compact('field', 'totalBookings', 'totalRevenue', 'upcomingBookings'));
    }

    /**
     * Menampilkan form untuk membuat lapangan baru.
     */
    public function create()
    {
        return view('admin.fields.create');
    }

    /**
     * Menyimpan data lapangan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer',
            'hourly_rate' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'image|max:2048', // Validasi array gambar
            'facilities' => 'nullable|string', // Validasi string fasilitas
        ]);

        // Simpan Data Utama Field
        $path = $request->hasFile('image') ? $request->file('image')->store('fields', 'public') : null;

        $field = Field::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'hourly_rate' => $request->hourly_rate,
            'image' => $path,
        ]);

        // Simpan Galeri Tambahan (Multiple Upload)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $photo) {
                $galleryPath = $photo->store('fields/gallery', 'public');
                FieldGallery::create([
                    'field_id' => $field->id,
                    'image' => $galleryPath
                ]);
            }
        }

        // Simpan Fasilitas (Pisahkan berdasarkan Koma)
        if ($request->facilities) {
            $facilitiesArray = explode(',', $request->facilities);
            foreach ($facilitiesArray as $item) {
                FieldFacility::create([
                    'field_id' => $field->id,
                    'name' => trim($item) // Hapus spasi berlebih
                ]);
            }
        }

        return redirect()->route('admin.fields.index')->with('success', 'Field created successfully');
    }

    /**
     * Menampilkan form edit untuk lapangan tertentu.
     */
    public function edit(Field $field) // Route Model Binding (otomatis cari id)
    {
        return view('admin.fields.edit', compact('field'));
    }

    /**
     * Mengupdate data lapangan di database.
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer',
            'hourly_rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($field->image) {
                Storage::disk('public')->delete($field->image);
            }
            // Update property image pada model (akan disimpan saat method update() dipanggil di bawah)
            $field->image = $request->file('image')->store('field_images', 'public');
        }

        // Update data lainnya
        $field->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'hourly_rate' => $request->hourly_rate,
            // Catatan: Jika $field->image diubah di blok if di atas, 
            // pemanggilan update() ini akan otomatis menyimpan perubahan image juga 
            // karena update() memicu save() pada instance model.
        ]);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Field updated successfully');
    }

    /**
     * Menghapus data lapangan.
     */
    public function destroy(Field $field)
    {
        if ($field->image) {
            Storage::disk('public')->delete($field->image);
        }

        $field->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', 'Field deleted successfully');
    }

    public function deleteGallery($galleryId)
    {
        $gallery = FieldGallery::findOrFail($galleryId);

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    public function updateGallery(Request $request, Field $field)
    {
        // Cek hanya validasi galeri.
        $request->validate([
            'gallery.*' => 'required|image|max:2048',
        ]);

        // Simpan Galeri Tambahan (Multiple Upload)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $photo) {
                $galleryPath = $photo->store('fields/gallery', 'public');
                FieldGallery::create([
                    'field_id' => $field->id,
                    'image' => $galleryPath
                ]);
            }
        }

        return back()->with('success', 'Foto galeri baru berhasil diunggah.');
    }

    public function updateFacilities(Request $request, Field $field)
    {
        $request->validate(['facilities' => 'nullable|string']);

        // Hapus semua fasilitas lama
        $field->facilities()->delete();

        // Simpan fasilitas baru
        if ($request->facilities) {
            $facilitiesArray = explode(',', $request->facilities);
            $newFacilities = [];
            foreach ($facilitiesArray as $item) {
                $name = trim($item);
                if (!empty($name)) {
                    $newFacilities[] = ['name' => $name];
                }
            }
            // Insert many lebih efisien
            $field->facilities()->createMany($newFacilities);
        }

        return back()->with('success', 'Fasilitas berhasil diperbarui.');
    }
}
