<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\LapanganPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganAdminController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::with('photos')->get();
        return view('admin.lapangans.index', compact('lapangans'));
    }

    public function create()
    {
        return view('admin.lapangans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:indoor,outdoor',
            'description' => 'nullable',
            'price_1jam' => 'nullable|numeric',
            'price_2jam' => 'required|numeric',
            'price_3jam' => 'required|numeric',
            'price_4jam' => 'required|numeric',
            'price_5jam' => 'required|numeric',
            'price_6jam' => 'nullable|numeric',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $lapangan = Lapangan::create($request->except('photos'));

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('lapangan', 'public');
                LapanganPhoto::create([
                    'lapangan_id' => $lapangan->id,
                    'photo_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.lapangans.index')->with('success', 'Lapangan ditambahkan.');
    }

    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangans.edit', compact('lapangan'));
    }

    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:indoor,outdoor',
            'description' => 'nullable',
            'price_1jam' => 'nullable|numeric',
            'price_2jam' => 'required|numeric',
            'price_3jam' => 'required|numeric',
            'price_4jam' => 'required|numeric',
            'price_5jam' => 'required|numeric',
            'price_6jam' => 'nullable|numeric',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = $request->except('photos');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $lapangan->update($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('lapangan', 'public');
                LapanganPhoto::create([
                    'lapangan_id' => $lapangan->id,
                    'photo_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.lapangans.index')->with('success', 'Lapangan diupdate.');
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        foreach ($lapangan->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();
        }
        $lapangan->delete();
        return back()->with('success', 'Lapangan dihapus.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);
        $lapangan->is_active = $request->is_active ?? !$lapangan->is_active;
        $lapangan->save();
        return back()->with('success', 'Status lapangan diperbarui.');
    }

    public function deletePhoto($photoId)
    {
        $photo = LapanganPhoto::findOrFail($photoId);
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();
        return back()->with('success', 'Foto dihapus.');
    }
}