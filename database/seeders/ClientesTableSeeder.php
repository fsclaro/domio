<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("clientes")->insert([
            "user_id" => 2,
            "cpf_administrador"=> "12345678901",
            "fone_administrador"=> "11987654321",
            "razao_social" => "Lopes Adm. de Condomínios",
            "nome_fantasia"=> "Loper Condomínios",
            "cnpj" => "09973194000186",
            "inscricao_estadual" => "081017238692",
            "fone"=> "1236314050",
            "email"=> "contato@lopes.com.br",
            "logradouro"=> "Travessa Estrela da Manhã",
            "nro"=> "192",
            "complemento"=> "5º andar, sala 52",
            "bairro"=> "Jardim das Flores",
            "cep"=> "08115011",
            "cidade"=> "São Paulo",
            "uf"=> "SP",
            "ativo"=> true,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);
    }
}
