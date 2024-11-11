<?php

namespace App\Filament\Resources\ComunicadosResource\Pages;

use Filament\Actions;
use App\Models\Imoveis;
use App\Models\Moradores;
use App\Models\Comunicados;
use App\Models\Condominios;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ComunicadosResource;

class CreateComunicados extends CreateRecord
{
    protected static string $resource = ComunicadosResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Comunicado criado com sucesso!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->user()->type == 1) {
            $data['tipo_origem'] = '1';
        } else {
            $data['tipo_origem'] = '2';
        }
        $data['dt_comunicado'] = now();
        $data['acao'] = '1';
        $data['user_envio_id'] = auth()->user()->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $dados = $this->record->toArray();

        if ($dados['tipo_origem'] == 1) {
            $moradores = Moradores::join('imoveis', 'imoveis.id', '=', 'moradores.imovel_id')
                ->where('imoveis.condominio_id', $dados['condominio_id'])
                ->get()->toArray();

            foreach($moradores as $m) {
                $comunicado['tipo_origem'] = $dados['tipo_origem'];
                $comunicado['condominio_id'] = $dados['condominio_id'];
                $comunicado['user_envio_id'] = $dados['user_envio_id'];
                $comunicado['user_destino_id'] = $m['user_id'];
                $comunicado['dt_comunicado'] = $dados['dt_comunicado'];
                $comunicado['mensagem'] = $dados['mensagem'];

                Comunicados::create($comunicado);
            }
        } else {
            $sindico = Condominios::where('condominios.id', $dados['condominio_id'])
                ->join('clientes', 'clientes.id', '=', 'condominios.clientes_id')
                ->get()->toArray();

            $comunicado['tipo_origem'] = $dados['tipo_origem'];
            $comunicado['condominio_id'] = $dados['condominio_id'];
            $comunicado['user_envio_id'] = $dados['user_envio_id'];
            $comunicado['user_destino_id'] = $sindico[0]['clientes_id'];
            $comunicado['dt_comunicado'] = $dados['dt_comunicado'];
            $comunicado['mensagem'] = $dados['mensagem'];

            Comunicados::create($comunicado);
        }

    }
}
