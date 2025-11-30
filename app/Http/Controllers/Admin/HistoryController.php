<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = History::with('user')->orderBy('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $histories = $query->paginate(20);

        return view('admin.history.index', compact('histories', 'search'));
    }
}
