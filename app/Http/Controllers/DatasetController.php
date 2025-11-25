<?php

namespace App\Http\Controllers;

use App\Models\MDataset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DatasetController extends Controller
{
    public function index()
    {
        return view('dataset.index');
    }

    public function getData(Request $request)
    {
        $query = MDataset::whereNull('m_dataset.deleted_at')
                ->select('m_dataset.*', 'cu.name as created_by_name')
                ->leftJoin('users as cu', 'm_dataset.created_by', '=', 'cu.id');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $editBtn = '<button type="button" class="btn btn-sm btn-warning edit-btn" data-id="'.$row->dataset_id.'">Edit</button>';
                $deleteBtn = '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->dataset_id.'">Delete</button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('updated_at', function($row) {
                return $row->updated_at ? Carbon::parse($row->updated_at)->format('Y-m-d H:i:s') : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Upload file
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('datasets', $filename, 'public');

            // Create dataset
            $dataset = MDataset::create([
                'name' => $request->name,
                'file_path' => $filePath,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dataset created successfully',
                'data' => $dataset
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if exists
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to create dataset',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $dataset = MDataset::with(['createdBy:id,name', 'updatedBy:id,name'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $dataset
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dataset not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'file' => 'nullable|file|mimes:csv,txt,xlsx,xls|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $dataset = MDataset::findOrFail($id);
            $oldFilePath = $dataset->file_path;

            $data = [
                'name' => $request->name,
                'updated_by' => Auth::id()
            ];

            // Handle file upload if new file provided
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('datasets', $filename, 'public');
                $data['file_path'] = $filePath;

                // Delete old file
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            }

            $dataset->update($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dataset updated successfully',
                'data' => $dataset
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete new uploaded file if exists
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to update dataset',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dataset = MDataset::findOrFail($id);
            
            // Soft delete
            $dataset->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dataset deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete dataset',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function forceDestroy($id)
    {
        try {
            DB::beginTransaction();

            $dataset = MDataset::withTrashed()->findOrFail($id);
            
            // Delete physical file
            if ($dataset->file_path && Storage::disk('public')->exists($dataset->file_path)) {
                Storage::disk('public')->delete($dataset->file_path);
            }

            // Permanent delete
            $dataset->forceDelete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dataset permanently deleted'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to permanently delete dataset',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $dataset = MDataset::withTrashed()->findOrFail($id);
            $dataset->restore();

            return response()->json([
                'success' => true,
                'message' => 'Dataset restored successfully',
                'data' => $dataset
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore dataset',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
