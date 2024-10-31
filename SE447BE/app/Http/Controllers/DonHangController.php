<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemMoiDiaChiNhanHang;
use App\Mail\XacNhanDonHang;
use App\Models\ChiTietDonHang;
use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DonHangController extends Controller
{

    public function thanhToanVNP(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        $dia_chi = DiaChi::orderByDESC('id')
            ->take(1)
            ->where('id_khach_hang', $khach_hang->id)->first();
        if (!$dia_chi) {
            return response()->json([
                'status' => false,
                'message' => "Vui Lòng Gửi Địa Chỉ"
            ]);
        } else if (count($request->ds_mua_sp) < 1) {
            return response()->json([
                'status' => false,
                'message' => "Hãy Chọn 1 Sản Phẩm Trước Khi Mua"
            ]);
        } else {
            if ($request->input('chon_thanh_toan') == 0) {
                $don_hang = DonHang::create([
                    'ma_don_hang'               => "",
                    'tong_tien_thanh_toan'      => 0,
                    'is_thanh_toan'             => 0,
                    'tinh_trang_don_hang'       => 0,
                    'ten_nguoi_nhan'            => $dia_chi->ten_nguoi_nhan,
                    'so_dien_thoai'             => $dia_chi->so_dien_thoai,
                    'dia_chi_giao_hang'         => $dia_chi->dia_chi,
                    'so_luong'                  => 0,
                    'is_giao_kho'               => 0,
                    'id_khach_hang'             => $khach_hang->id
                ]);

                $ma_don_hang = "HDBH" . (101086 + $don_hang->id);
                $tong_tien_thanh_toan = 0;
                $so_luong = 0;
                foreach ($request->ds_mua_sp as $key => $value) {
                    $tong_tien_thanh_toan += $value['thanh_tien'];
                    $so_luong += $value['so_luong'];
                    ChiTietDonHang::where('id', $value['id'])->update([
                        'id_hoa_don'    => $don_hang->id,
                    ]);
                };

                $don_hang->ma_don_hang = $ma_don_hang;
                $don_hang->tong_tien_thanh_toan = $tong_tien_thanh_toan;
                $don_hang->so_luong = $so_luong;
                $don_hang->save();
                // $dia_chi->delete();
                // $dia_chi->save();
                // $link   =   "https://img.vietqr.io/image/MB-1910061030119-qr_only.png?amount=" . $tong_tien_thanh_toan . "&addInfo=" . $ma_don_hang;
                $link   =   "https://api.vietqr.io/image/970422-000026029999-cqf7OD8.jpg?accountName=LE%20QUANG%20VIEN&amount=" . $tong_tien_thanh_toan . "&addInfo=" . $ma_don_hang;

                $bien_1['ten_nguoi_nhan']           =   $dia_chi->ten_nguoi_nhan;
                $bien_1['so_dien_thoai_nhan']       =   $dia_chi->so_dien_thoai;
                $bien_1['dia_chi_nhan_hang']        =   $dia_chi->dia_chi;
                $bien_1['tong_tien_thanh_toan']     =   $tong_tien_thanh_toan;
                $bien_1['link_qr_code']             =   $link;
                $bien_2                             =   $request->ds_mua_sp;

                Mail::to($khach_hang->email)->send(new XacNhanDonHang($bien_1, $bien_2));

                return response()->json([
                    'status' => true,
                    'message' => "Vui Lòng Vào Email Để Thanh Toán"
                ]);
            } else {
                $don_hang = DonHang::create([
                    'ma_don_hang'               => "",
                    'tong_tien_thanh_toan'      => 0,
                    'is_thanh_toan'             => 0,
                    'tinh_trang_don_hang'       => 0,
                    'ten_nguoi_nhan'            => $dia_chi->ten_nguoi_nhan,
                    'so_dien_thoai'             => $dia_chi->so_dien_thoai,
                    'dia_chi_giao_hang'         => $dia_chi->dia_chi,
                    'so_luong'                  => 0,
                    'is_giao_kho'               => 0,
                    'id_khach_hang'             => $khach_hang->id
                ]);

                $ma_don_hang = "HDBH" . (101086 + $don_hang->id);
                $tong_tien_thanh_toan = 0;
                $so_luong = 0;
                foreach ($request->ds_mua_sp as $key => $value) {
                    $tong_tien_thanh_toan += $value['thanh_tien'];
                    $so_luong += $value['so_luong'];
                    ChiTietDonHang::where('id', $value['id'])->update([
                        'id_hoa_don'    => $don_hang->id,
                    ]);
                };

                $don_hang->ma_don_hang = $ma_don_hang;
                $don_hang->tong_tien_thanh_toan = $tong_tien_thanh_toan;
                $don_hang->so_luong = $so_luong;
                $don_hang->save();
                // $dia_chi->delete();
                // $dia_chi->save();
                return response()->json([
                    'status' => true,
                    'message' => "Đặt đơn hàng thành công"
                ]);
            }
            $dia_chi->delete();
            $dia_chi->save();
        }
    }


    public function donHangProfile(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        $donhang = DonHang::where('id_khach_hang', $khach_hang->id)->get();
        return response()->json([
            'data'      => $donhang
        ]);
    }


    public function destroys(Request $request)
    {
        $don_hang = DonHang::where('id', $request->id)->first();
        if ($don_hang) {
            $don_hang->delete();
            return response([
                'status'  => true,
                'message' => 'Đã Xóa Thành Công',
            ]);
            $don_hang->save();
        } else {
            return response([
                'status'  => false,
                'message' => 'Xóa Thất Bại',
            ]);
        }
    }

    public function deleteProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $products = DonHang::where('id', $request->id)->where('id_khach_hang', $user->id)->first();
        if ($products) {
            $products->delete();
            return response([
                'status'  => true,
                'message' => 'Đã Xóa Thành Công',
            ]);
            $products->save();
        } else {
            return response([
                'status'  => false,
                'message' => 'Xóa Thất Bại',
            ]);
        }
    }
}
