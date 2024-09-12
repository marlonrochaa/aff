<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Sheets;

class SyncSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Caminho para o arquivo de credenciais da Service Account
        $path = storage_path('app/google-credentials.json');

        // Configurar o cliente do Google
        $client = new Client();
        $client->setAuthConfig($path);
        $client->addScope(Sheets::SPREADSHEETS_READONLY);

        // Instanciar o serviço do Google Sheets
        $service = new Sheets($client);

        // ID da planilha do Google Sheets (pode ser obtido da URL da planilha)
        $spreadsheetId = '1cyg_LZejIfcxDzPVJXFgGP5mbHxXWxLo6SzZ96PLEYc';

        // Nome da aba e intervalo (por exemplo, "Sheet1!A1:D10")
        $range = '';

        // Busca os dados da planilha
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        dd($values);

        if (empty($values)) {
            $this->info('Nenhum dado encontrado.');
        } else {
            foreach ($values as $row) {
                // Aqui você pode processar cada linha da planilha
                $this->info(implode(', ', $row));
            }
        }

        return 0;
    }
}
