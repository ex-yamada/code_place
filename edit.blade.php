@extends('layouts.menu')

@section('content')
        <div class="contents">
            <!-- section -------------------------------- -->
            <h2 class="h2">アカウント - 更新</h2>
            <section class="section">
                <form name="edit_form" action="{{ route('accounts_update', $data->admin_id) }}" method="POST" id="form-sys-id">
                    @csrf

                    <ul class="form_area">
                        <li>
                            <label>アカウント名<img src="/assets/img/common/required.svg" alt="required"></label>
                            <div class="flex_row">
                                <input type="text" name="name" value="{{ old('name', $data->name) }}" maxlength="64" placeholder="CMSにログインし、案件や人材の管理、提案の登録を行うユーザの名前を登録する">
@if ($errors->has('name'))
                                <p class="error_text">{{ $errors->first('name') }}</p>
@endif
                            </div>
                        </li>
                        <li>
                            <div>
                                <label>ステータス<img src="/assets/img/common/required.svg" alt="required"></label>
                            </div>
                            <div>
                                <ul class="flex_01">
@foreach ($status as $key => $value)
                                        <li>
                                            <input type="radio" id="status-{{ $key }}" name="status" value="{{ $key }}"{{ old('status', $data->status) == $key ? ' checked' : '' }}>
                                            <label for="status-{{ $key }}">{{ $value }}</label>
                                        </li>
@endforeach
                                </ul>
@if ($errors->has('status'))
                            <p class="error_text">{{ $errors->first('status') }}</p>
@endif
                            </div>
                        </li>
                        <li>
                            <label>メールアドレス<img src="/assets/img/common/required.svg" alt="required"></label>
                            <div class="flex_row">
                                <input type="email" name="email" value="{{ old('email', $data->email) }}" maxlength="255" placeholder="メールアドレスを登録する ※他のアカウントで使用しているメールアドレスは登録できません">
@if ($errors->has('email'))
                                <p class="error_text">{{ $errors->first('email') }}</p>
@endif
                            </div>
                        </li>
                        <li>
                            <label>パスワード</label>
                            <div class="flex_row">
                                <input type="password" name="password" value="" minlength="8" maxlength="16" placeholder="パスワードは、8文字以上 16文字以下で登録する">
@if ($errors->has('password'))
                                <p class="error_text">{{ $errors->first('password') }}</p>
@endif
                            </div>
                        </li>
                        <li>
                            <label>パスワード（確認）</label>
                            <div class="flex_row">
                                <input type="password" name="password_confirmation" value="" minlength="8" maxlength="16">
@if ($errors->has('password_confirmation'))
                                <p class="error_text">{{ $errors->first('password_confirmation') }}</p>
@endif
                            </div>
                        </li>
@php
$OrganiZationGroup = [
"departments" => $department,
"divisions"   => $division,
"units"       => $unit,
];
// old情報
$oldOrganiZationGroup = [
"department_id" => old('department_id'),
"division_id"   => old('division_id'),
"unit_id"       => old('unit_id'),
];
// エラー情報
$errorInfo = [
"department_id" => $errors->first('department_id'),
"division_id"   => $errors->first('division_id'),
"unit_id"       => $errors->first('unit_id'),
];
// 既存のエリア登録情報
$savedOrganiZationGroup = [
    "department_id" => $data->department_id,
    "division_id"   => $data->division_id,
    "unit_id"       => $data->unit_id,
];
@endphp
                            <li>
                                <label>組織<img src="/assets/img/common/required.svg" alt="required"></label>
                                    <account-organization-component
                                    :organization-group="{{ json_encode($OrganiZationGroup) }}"
                                    :old-organization-group="{{ json_encode($oldOrganiZationGroup) }}"
                                    :error-info="{{ json_encode($errorInfo) }}"
                                    :default-organization-group="{{ json_encode($savedOrganiZationGroup) }}">
                                    </account-organization-component>
                            </li>
@if ($errors->has('admin_role_id'))
                                <p class="error_text">{{ $errors->first('admin_role_id') }}</p>
@endif

                        <li>
                            <label>アカウント種別<img src="/assets/img/common/required.svg" alt="required"></label>
                            <div>
                                <select name="admin_role_id" required>
@foreach ($admin_roles as $item)
                                    <option value="{{ $item->admin_role_id }}" {{ old('admin_role_id', $data->admin_role_id) == (string) $item->admin_role_id ? 'selected' : ''}}>{{ $item->admin_role_name }}</option>
@endforeach
                                </select>
@if ($errors->has('admin_role_id'))
                                <p class="error_text">{{ $errors->first('admin_role_id') }}</p>
@endif
                            </div>
                        </li>
                        <li>
                            <label>営業担当コード</label>
                            <div class="flex_row">
                                <input type="number" name="staff_code" value="{{ old('staff_code', $data->staff_code) }}" min="0" max="4294967295" placeholder="営業担当コードを登録する ※他のアカウントで使用している営業担当コードは登録できません">
@if ($errors->has('staff_code'))
                                <p class="error_text">{{ $errors->first('staff_code') }}</p>
@endif
                            </div>
                        </li>
                        <li>
                            <label>備考</label>
                            <div class="flex_row">
                                <textarea name="note" rows="4" placeholder="備考を登録する" style="width:100%;">{{ old('note', $data->note) }}</textarea>
@if ($errors->has('note'))
                                <p class="error_text">{{ $errors->first('note') }}</p>
@endif
                            </div>
                        </li>
                    </ul>
                </form>
            </section>
            <!-- / section -------------------------------- -->
            <!-- ボタン -->
            <div class="button">
                <ul>
                    <li>
                        <div class="target button-modal" id="m_open_1">保存する</div>
                    </li>
                    <li>
                        <div class="gray-btn" onclick="location.href='{{ route('accounts') }}'">一覧に戻る</div>
                    </li>
                </ul>
            </div>
            <!-- /ボタン -->
        </div>


        <!-- --------------- モーダル背景 --------------- -->
        <div id="mask_fix" class="hidden"></div>
        <!-- --------------- モーダル内容 --------------- -->
        <div class="modal_main">
            <div id="m_open_1_modal" class="hidden">
                <div class="modal open">
                    <div class="modal_inner">
                        <div class="modal_inner__in">
                            <p>保存します。<br>よろしいですか？</p>
                            <div class="button">
                                <ul>
                                    <li>
                                        <div class="primary-btn target modal_ok" onclick="modal_ok('form-sys-id', 'm_open_1_modal');">保存する</div>
                                    </li>
                                    <li>
                                        <div class="gray-btn target modal_cancel">キャンセル</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
