@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('sidebar')
<div class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" 
           href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/barang*') ? 'active' : '' }}" 
           href="{{ route('admin.barang.index') }}">
            <i class="fas fa-box"></i> Manajemen Barang
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/mahasiswa*') ? 'active' : '' }}" 
           href="{{ route('admin.mahasiswa.index') }}">
            <i class="fas fa-users"></i> Manajemen Mahasiswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/peminjaman*') ? 'active' : '' }}" 
           href="{{ route('admin.peminjaman.index') }}">
            <i class="fas fa-clipboard-list"></i> Manajemen Peminjaman
        </a>
    </li>
</div>
@endsection