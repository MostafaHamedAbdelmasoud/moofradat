<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/19/2018
 * Time: 8:43 PM
 */

$userr = \App\User::where('username', $username)->with('followers')->first();
//dd($userr);
?>

<!-- Modal -->
<div id="userFollowers" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">قائمة المتابعون</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>الإسم</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if($userr->followers->count() > 0)
                        @foreach($userr->followers as $u)
                            <tr>
                                <td>
                                    <img src="{{ asset('public/uploads/avatar/'.$u->avatar) }}" class="img-thumbnail"
                                         alt="{{ $u->name }}" width="40" height="40">
                                    <a href="{{ url('/'.$u->username) }}">{{ $u->name }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p> لا يوجد متابعون</p>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
            </div>
        </div>

    </div>
</div>

