<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        
        $permissions = [

    // leads
    'access_leads',
    'create_leads',
    'show_leads',
    'edit_leads',
    'delete_leads',

    // installments
    'access_installments',
    'create_installments',
    'show_installments',
    'edit_installments',
    'delete_installments',

    // tickets
    'access_tickets',
    'create_tickets',
    'show_tickets',
    'edit_tickets',
    'delete_tickets',

    // salescategory
    'access_salescategory',
    'create_salescategory',
    'show_salescategory',
    'edit_salescategory',
    'delete_salescategory',

    // customers
    'access_customers',
    'create_customers',
    'show_customers',
    'edit_customers',
    'delete_customers',

    // sales
    'access_allsales',
    'access_sales',
    'create_sales',
    'show_sales',
    'edit_sales',
    'delete_sales',

    // presales
    'access_presales',
    'create_presales',
    'show_presales',
    'edit_presales',
    'delete_presales',

    // sales return
    'access_salesreturn',
    'create_salesreturn',
    'show_salesreturn',
    'edit_salesreturn',
    'delete_salesreturn',

    // inventory
    'access_ime',
    'access_inventory',
    'create_inventory',
    'show_inventory',
    'edit_inventory',
    'delete_inventory',

    // suppliers
    'access_suppliers',
    'create_suppliers',
    'show_suppliers',
    'edit_suppliers',
    'delete_suppliers',

    // purchases
    'access_purchases',
    'create_purchases',
    'show_purchases',
    'edit_purchases',
    'delete_purchases',

    // purchase return
    'access_purchasereturn',
    'create_purchasereturn',
    'show_purchasereturn',
    'edit_purchasereturn',
    'delete_purchasereturn',

    // technicians
    'access_technicians',
    'create_technicians',
    'show_technicians',
    'edit_technicians',
    'delete_technicians',

    // stock transfers
    'access_stocktransfers',
    'create_stocktransfers',
    'show_stocktransfers',
    'edit_stocktransfers',
    'delete_stocktransfers',

    // request transfers
    'access_requestransfers',
    'create_requestransfers',
    'show_requestransfers',
    'edit_requestransfers',
    'delete_requestransfers',
    'status_requestransfers',
    'accept_requestransfers',
];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}