@extends('layouts.default')

@section('title', '收支明细')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
    @component('layouts._dealerheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
    <div class="swich-container" align="center">
        <div class="swich-bar3">
            <div class="col-xs-4 col-md-4 col-lg-4 text-45-b3 swich-text-container" align="center">
                收入
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4 text-45-white swich-text-container" align="center">
                全部
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4 text-45-b3 swich-text-container" align="center">
                支出
            </div>
        </div>
    </div>
</section>
<section class="body">
    <ul class="board1">
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1.5rem;">
                <span class="pull-left text-36">提成收入</span>
                <span class="pull-right text-36-b3">2018-08-15</span>
            </div>
            <div class="revenus-item-row" style="top:3rem;">
                <span class="pull-left text-36">余额8.67</span>
                <span class="pull-right text-36">+1.32</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1.5rem;">
                <span class="pull-left text-36">提成收入</span>
                <span class="pull-right text-36-b3">2018-08-16</span>
            </div>
            <div class="revenus-item-row" style="top:3rem;">
                <span class="pull-left text-36">余额10.5</span>
                <span class="pull-right text-36">+5.20</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1.5rem;">
                <span class="pull-left text-36">提现支出</span>
                <span class="pull-right text-36-b3">2018-08-17</span>
            </div>
            <div class="revenus-item-row" style="top:3rem;">
                <span class="pull-left text-36">余额2.67</span>
                <span class="pull-right text-36">-100.00</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
    </ul>
</section>
<section class="footer">
    <div align="center" style="margin-top:1.5rem; width: 100%;">
        <a class="button-style-red">加载更多</a>
    </div>
</section>
@endsection