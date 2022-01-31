@extends('layouts.app')

@section('app-content')

    <div class='container py-16 space-y-8'>

        <div class="color-info s">После обновления данных вам нужно будет войти заново</div>

        <div class="w-1/4 m-auto space-y-12">
            
            <div class="space-y-4">

                <h1>Аккаунт</h1>

                <livewire:edit 
                    :class="$class"
                    :row="id()"
                    :fields="['name' => user()->name, 'surname' => user()->surname, 'phone' => user()->phone]"
                    :rules="$accountRules"
                    styles="flex-col space-y-2 s"
                    :key="'account-edit'" 
                />

            </div>

            <div class="space-y-4">
                
                <h1>Изменение пароля</h1>

                <livewire:edit 
                    :class="$class"
                    :row="id()"
                    :fields="['old_password' => '', 'password' => '', 'password_confirmation' => '']"
                    :rules="$passwordRules"
                    styles="flex-col space-y-2 s"
                    :key="'password-edit'" 
                />

            </div>

        </div>

    </div>


@endsection