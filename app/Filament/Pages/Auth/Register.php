<?php

namespace App\Filament\Pages\Auth;

use App\Models\Team;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as RegisterPage;
use Illuminate\Database\Eloquent\Model;

class Register extends RegisterPage
{
    public function handleRegistration(array $data) : Model
    {
        $user = $this->getUserModel()::create($data);
       
        $team = Team::create($data);
 
        $team->members()->attach($user);

        return $user;
    }

    public function afterRegister(): void
    {
        //
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent()->label('Nome'),
                $this->getEmailFormComponent()->label('E-mail'),
                TextInput::make('cnpj')
                ->label('CNPJ')
                ->required()
                ->mask('99.999.999/9999-99'),
                Select::make('tax_regime')
                    ->label('Regime Tributário')
                    ->required()
                    ->placeholder('Selecione o regime tributário')
                    ->options([
                        '01' => 'Lucro Real',
                        '02' => 'Lucro Presumido',
                        '03' => 'Simples Nacional',
                    ]),
                $this->getPasswordFormComponent()->label('Senha'),
                $this->getPasswordConfirmationFormComponent()->label('Confirme a senha'),
            ])
           ;
    }       

}
