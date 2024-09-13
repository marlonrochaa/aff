<?php

namespace App\Console\Commands;

use App\Models\FinancialReport;
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
        $range = 'PRINCIPAL!A1:P360';

        // Busca os dados da planilha
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            $this->info('Nenhum dado encontrado.');
        } else {
            unset($values[0]);
            foreach ($values as $row) {
                $date = \Carbon\Carbon::createFromFormat('d/m/Y', $row[0])->format('Y-m-d');

                FinancialReport::updateOrCreate([
                    'date' => $date,
                ], [
                    'deposit_count' => $row[1],
                    'deposit_amount' => $this->formatCurrency($row[2]),
                    'withdrawal_count' => $row[4],
                    'withdrawal_amount' => $this->formatCurrency($row[5]),
                    'ftd_count' => $this->formatCurrency($row[12]),
                    'ftd_amount' => $this->formatCurrency($row[13]),
                    'registration' => $this->formatCurrency($row[15]),
                ]);
            }
        }

        return 0;
    }

    //formato o valor para decimal
    private function formatCurrency($value)
    {
        $money = str_replace(['R$',], ['', ''], $value);
        return str_replace(',', '.', str_replace('.', '', $money));
    }
}
