<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            // Admin: semua aspirasi
            $query = Aspirasi::with('user');

            // Filter desa jika ada
            if ($request->village) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('village', $request->village);
                });
            }

            $aspirasis = $query->latest()->paginate(10);
        } else {
            $aspirasis = Auth::user()->aspirasis()->latest()->paginate(10);
        }

        return view('dashboard', compact('aspirasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('aspirasi', 'public');
        }

        Auth::user()->aspirasis()->create($data);

        return redirect()->route('aspirasi.index')
            ->with('success', 'Aspirasi berhasil dikirim!');
    }

    public function reply(Request $request, Aspirasi $aspirasi)
    {
        $request->validate(['reply' => 'required']);

        $aspirasi->update([
            'reply' => $request->reply,
            'status' => 'processed'
        ]);

        return back()->with('success', 'Balasan terkirim ke warga!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspirasi $aspirasi)
    {
        //
    }
}
