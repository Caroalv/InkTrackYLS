<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Subgroup;
use App\Models\MeasurementUnit;
use App\Models\Supplier;
use App\Models\DocType;
use App\Models\Item;
use App\Models\MovHeader;
use App\Models\MovDetail;
use App\Models\Dyelote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador por defecto
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);

        // 2. Grupos y Subgrupos
        $group = Group::create(['groupname' => 'Production']);
        $subgroup = Subgroup::create([
            'groupid' => $group->id,
            'subgroupname' => 'Prisma Group',
        ]);

        // 3. Unidad de Medida
        $unit = MeasurementUnit::create(['mesureunitname' => 'Kg']);

        // 4. Proveedor
        $supplier = Supplier::create([
            'suppliername' => 'Plastisol',
            'contact' => 'Ventas Plastisol',
            'phonenumber' => '2200-0000',
            'email' => 'ventas@plastisol.com',
        ]);

        // 5. Tipos de Documento (Entrada / Salida)
        $docIn = DocType::create([
            'kind' => 'IN',
            'doctype' => 'REC',
            'doctypefullname' => 'Recepción de Insumos',
        ]);

        $docOut = DocType::create([
            'kind' => 'OUT',
            'doctype' => 'SAL',
            'doctypefullname' => 'Salida a Producción',
        ]);

        // 6. Catálogo de Ítems (Tintas)
        $item1 = Item::create([
            'subgroupid' => $subgroup->id,
            'muid' => $unit->id,
            'phcode' => 'PH-001',
            'itemname' => 'Taurus Barrier Gray',
            'minstock' => 2.00,
            'maxstock' => 20.00,
            'currentstock' => 7.00,
            'estimatedunitweight' => 1.00,
        ]);

        $item2 = Item::create([
            'subgroupid' => $subgroup->id,
            'muid' => $unit->id,
            'phcode' => 'PH-002',
            'itemname' => 'Taurus Yellow',
            'minstock' => 2.00,
            'maxstock' => 20.00,
            'currentstock' => 5.00,
            'estimatedunitweight' => 1.00,
        ]);

        $item3 = Item::create([
            'subgroupid' => $subgroup->id,
            'muid' => $unit->id,
            'phcode' => 'PH-003',
            'itemname' => 'Taurus Blue Marine',
            'minstock' => 2.00,
            'maxstock' => 20.00,
            'currentstock' => 1.00,
            'estimatedunitweight' => 1.00,
        ]);

        // 7. Registro de Cabecera de Movimiento (Entrada inicial)
        $header = MovHeader::create([
            'doctypeid' => $docIn->id,
            'supplierid' => $supplier->id,
            'docnumber' => 'REC-2026-001',
            'docdate' => '2026-07-20',
            'YLSindate' => '2026-07-20',
            'SPindate' => '2026-07-22',
        ]);

        // 8. Detalles del Movimiento y Registro de Lotes (Dyelotes)
        $itemsData = [
            [
                'item' => $item1,
                'qty' => 10.00,
                'weight' => 3.00,
                'lote' => 'LOT-TBG-01',
                'msds' => '2026-07-19',
                'balance' => 7.00,
            ],
            [
                'item' => $item2,
                'qty' => 10.00,
                'weight' => 5.00,
                'lote' => 'LOT-TY-01',
                'msds' => '2021-07-20',
                'balance' => 5.00,
            ],
            [
                'item' => $item3,
                'qty' => 10.00,
                'weight' => 9.00,
                'lote' => 'LOT-TBM-01',
                'msds' => '2023-07-21',
                'balance' => 1.00,
            ],
        ];

        foreach ($itemsData as $data) {
            $detail = MovDetail::create([
                'headerid' => $header->id,
                'itemid' => $data['item']->id,
                'qty' => $data['qty'],
                'realweight' => $data['weight'],
            ]);

            Dyelote::create([
                'movdetailsid_IN' => $detail->id,
                'itemid' => $data['item']->id,
                'dyelote' => $data['lote'],
                'duedate' => $data['msds'],
                'MSDS' => 'MSDS-' . $data['item']->phcode,
                'qtyxlote' => $data['qty'],
                'weightxlote' => $data['weight'],
                'qtybalance' => $data['balance'],
                'weightbalance' => $data['weight'],
            ]);
        }
    }
}