<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemMoiDiaChiNhanHang;
use App\Models\DiaChi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaChiController extends Controller
{

    public function create(ThemMoiDiaChiNhanHang $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        if ($khach_hang) {
            $khach_hang = DiaChi::create([
                'id_khach_hang'     => $khach_hang->id,
                'ten_nguoi_nhan'    => $request->ten_nguoi_nhan,
                'so_dien_thoai'     => $request->so_dien_thoai,
                'dia_chi'           => $request->dia_chi,
                'email'             =>  $request->email,
                'ghi_chu'           =>  $request->ghi_chu,
            ]);
            return response()->json([
                'status' => true,
                'message' => "Bạn đã thêm mới địa chỉ thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function store()
    {
        $khach_hang = Auth::guard('sanctum')->user();

        $data = DiaChi::where('id_khach_hang', $khach_hang->id)->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateDiaChi(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        $dia_chi    = DiaChi::where('id', $request->id)->where('id_khach_hang', $khach_hang->id)->first();
        if ($dia_chi) {
            try {
                $dia_chi->update([
                    'ten_nguoi_nhan'    => $request->ten_nguoi_nhan,
                    'so_dien_thoai'     => $request->so_dien_thoai,
                    'dia_chi'           => $request->dia_chi,
                    'email'             =>  $request->email,
                    'ghi_chu'           =>  $request->ghi_chu,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => "Bạn đã cập nhật địa chỉ thành công!"
                ]);
            } catch (Exception) {
                return response()->json([
                    'status' => false,
                    'message' => "Có lỗi xảy ra!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Bạn không thuộc sở hữu địa chỉ này!"
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        $dia_chi    = DiaChi::where('id', $request->id)->where('id_khach_hang', $khach_hang->id)->first();
        if ($dia_chi) {
            try {
                $dia_chi->delete();

                return response()->json([
                    'status' => true,
                    'message' => "Bạn đã xóa địa chỉ thành công!"
                ]);
            } catch (Exception) {
                return response()->json([
                    'status' => false,
                    'message' => "Có lỗi xảy ra!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Bạn không thuộc sở hữu địa chỉ này!"
            ]);
        }
    }
}
