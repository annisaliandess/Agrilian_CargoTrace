<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Carrier;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Models\ShipmentItem;
use App\Models\TrackingEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users with RBAC
        $admin = User::firstOrCreate(
            ['email' => 'admin@agrilian.com'],
            [
                'name' => 'Ayaa Liandes (Admin)',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $operatorGayo = User::firstOrCreate(
            ['email' => 'operator@agrilian.com'],
            [
                'name' => 'Reza Pratama (Gayo Dispatcher)',
                'password' => Hash::make('password123'),
                'role' => 'operator',
            ]
        );

        $operatorBelawan = User::firstOrCreate(
            ['email' => 'operator.belawan@agrilian.com'],
            [
                'name' => 'Budi Santoso (Belawan Port Ops)',
                'password' => Hash::make('password123'),
                'role' => 'operator',
            ]
        );

        $customerKoperasi = User::firstOrCreate(
            ['email' => 'koperasi.gayo@agrilian.com'],
            [
                'name' => 'Koperasi Kopi Gayo Highland',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );

        $customerAmsterdam = User::firstOrCreate(
            ['email' => 'buyer.amsterdam@eurocoffee.nl'],
            [
                'name' => 'Amsterdam Coffee Roasters B.V.',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );

        $customerSingapore = User::firstOrCreate(
            ['email' => 'procurement@singaagro.sg'],
            [
                'name' => 'SingaAgro Fresh Singapore Pte Ltd',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );

        // 2. Seed Strategic Locations (Takengon -> Bireuen -> Belawan/KNO -> Singapore -> Rotterdam)
        $locTakengon = Location::firstOrCreate(
            ['code' => 'IDTKN'],
            [
                'name' => 'Takengon Agro Logistics Warehouse',
                'type' => 'ORIGIN_WAREHOUSE',
                'city' => 'Takengon, Aceh Tengah',
                'country' => 'Indonesia',
                'latitude' => 4.6293,
                'longitude' => 96.8458,
            ]
        );

        $locBireuen = Location::firstOrCreate(
            ['code' => 'IDBIR'],
            [
                'name' => 'Bireuen Trans-Sumatra Checkpoint',
                'type' => 'INLAND_CHECKPOINT',
                'city' => 'Bireuen',
                'country' => 'Indonesia',
                'latitude' => 5.2045,
                'longitude' => 96.7009,
            ]
        );

        $locBelawan = Location::firstOrCreate(
            ['code' => 'IDBLW'],
            [
                'name' => 'Belawan International Container Terminal',
                'type' => 'SEAPORT',
                'city' => 'Medan, Sumatera Utara',
                'country' => 'Indonesia',
                'latitude' => 3.7844,
                'longitude' => 98.6833,
            ]
        );

        $locKualanamu = Location::firstOrCreate(
            ['code' => 'KNO'],
            [
                'name' => 'Kualanamu International Cargo Terminal',
                'type' => 'AIRPORT',
                'city' => 'Deli Serdang',
                'country' => 'Indonesia',
                'latitude' => 3.6422,
                'longitude' => 98.8853,
            ]
        );

        $locSingapore = Location::firstOrCreate(
            ['code' => 'SGSIN'],
            [
                'name' => 'PSA Singapore Container Terminal',
                'type' => 'DESTINATION_PORT',
                'city' => 'Singapore',
                'country' => 'Singapore',
                'latitude' => 1.2644,
                'longitude' => 103.8220,
            ]
        );

        $locRotterdam = Location::firstOrCreate(
            ['code' => 'NLRTM'],
            [
                'name' => 'Port of Rotterdam Maasvlakte',
                'type' => 'DESTINATION_PORT',
                'city' => 'Rotterdam',
                'country' => 'Netherlands',
                'latitude' => 51.9547,
                'longitude' => 4.0322,
            ]
        );

        // 3. Seed Multimodal Carriers
        $carrierLiandes = Carrier::firstOrCreate(
            ['code' => 'AGLN'],
            [
                'name' => 'AgriLian Highland Fleet Logistics',
                'transport_mode' => 'TRUCK',
                'contact_email' => 'dispatch@agrilian.id',
                'phone' => '+62-643-22891',
                'is_active' => true,
            ]
        );

        $carrierMaersk = Carrier::firstOrCreate(
            ['code' => 'MAERSK'],
            [
                'name' => 'Maersk Line Ocean Transport',
                'transport_mode' => 'VESSEL',
                'contact_email' => 'ocean.cargo@maersk.com',
                'phone' => '+31-10-503-4000',
                'is_active' => true,
            ]
        );

        $carrierGaruda = Carrier::firstOrCreate(
            ['code' => 'GIA'],
            [
                'name' => 'Garuda Indonesia Cargo',
                'transport_mode' => 'AIR',
                'contact_email' => 'cargo.kno@garuda-indonesia.com',
                'phone' => '+62-61-888-8888',
                'is_active' => true,
            ]
        );

        $carrierSamudera = Carrier::firstOrCreate(
            ['code' => 'SMDR'],
            [
                'name' => 'Samudera Indonesia Feeder',
                'transport_mode' => 'VESSEL',
                'contact_email' => 'feeder.ops@samudera.id',
                'phone' => '+62-21-534-4500',
                'is_active' => true,
            ]
        );

        // 4. Seed Shipments

        // Shipment 1: Hero Ocean Export (Takengon -> Belawan -> Rotterdam, currently in Singapore)
        $shipment1 = Shipment::firstOrCreate(
            ['tracking_number' => 'AGLN-2026-GY001'],
            [
                'customer_id' => $customerAmsterdam->id,
                'carrier_id' => $carrierMaersk->id,
                'origin_id' => $locTakengon->id,
                'destination_id' => $locRotterdam->id,
                'cargo_type' => 'Arabica Gayo Specialty Grade 1 (Fair Trade Organic)',
                'weight_kg' => 18000.00,
                'volume_cbm' => 33.20,
                'expected_departure' => Carbon::parse('2026-11-01 08:00:00'),
                'expected_arrival' => Carbon::parse('2026-11-28 14:00:00'),
                'estimated_arrival' => Carbon::parse('2026-11-28 14:00:00'),
                'status' => 'IN_TRANSIT',
                'is_delayed' => false,
                'delay_duration_hours' => 0,
                'delay_severity' => 'NONE',
                'delay_reason' => null,
                'current_location_id' => $locSingapore->id,
            ]
        );

        // Items for Shipment 1
        ShipmentItem::firstOrCreate(
            ['shipment_id' => $shipment1->id, 'item_name' => 'Gayo Wet-Hulled (Giling Basah) Arabica'],
            [
                'quantity' => 200,
                'weight_kg' => 12000.00,
                'package_type' => 'GrainPro Hermetic Bag in Jute 60kg',
                'description' => 'Biji kopi mentah Arabika Gayo kualitas ekspor premium dengan aroma rempah khas Takengon. Moisture 11.4%, GrainPro hermetic, Takengon Highland Lot #GY26-A1',
            ]
        );
        ShipmentItem::firstOrCreate(
            ['shipment_id' => $shipment1->id, 'item_name' => 'Gayo Wine Process Micro-Lot Arabica'],
            [
                'quantity' => 100,
                'weight_kg' => 6000.00,
                'package_type' => 'GrainPro Hermetic Bag in Jute 60kg',
                'description' => 'Specialty anaerobic fermented natural process coffee, SCA Score 88.5',
            ]
        );

        // Tracking Events for Shipment 1
        $events1 = [
            [
                'location_id' => $locTakengon->id,
                'status' => 'CREATED',
                'event_time' => Carbon::parse('2026-11-01 08:00:00'),
                'latitude' => 4.6293,
                'longitude' => 96.8458,
                'description' => 'Export booking manifest submitted & Phytosanitary Certificate issued in Takengon.',
                'created_by' => $operatorGayo->id,
            ],
            [
                'location_id' => $locTakengon->id,
                'status' => 'BOOKED',
                'event_time' => Carbon::parse('2026-11-01 10:30:00'),
                'latitude' => 4.6293,
                'longitude' => 96.8458,
                'description' => 'Container sealed with GPS lock #AGLN-LOCK-0918. AgriLian Heavy Reefer Truck assigned.',
                'created_by' => $operatorGayo->id,
            ],
            [
                'location_id' => $locTakengon->id,
                'status' => 'PICKED_UP',
                'event_time' => Carbon::parse('2026-11-02 06:00:00'),
                'latitude' => 4.6293,
                'longitude' => 96.8458,
                'description' => 'Convoy departed Takengon warehouse traversing mountain route towards Bireuen.',
                'created_by' => $operatorGayo->id,
            ],
            [
                'location_id' => $locBireuen->id,
                'status' => 'IN_TRANSIT',
                'event_time' => Carbon::parse('2026-11-02 11:30:00'),
                'latitude' => 5.2045,
                'longitude' => 96.7009,
                'description' => 'Checkpoint cleared at Bireuen Trans-Sumatra. Temperature & humidity stable at 18°C / 55%.',
                'created_by' => $operatorGayo->id,
            ],
            [
                'location_id' => $locBelawan->id,
                'status' => 'IN_TRANSIT',
                'event_time' => Carbon::parse('2026-11-03 04:15:00'),
                'latitude' => 3.7844,
                'longitude' => 98.6833,
                'description' => 'Arrived at Belawan Container Port. Custom export inspection cleared (PEB #019283). Loaded on feeder vessel.',
                'created_by' => $operatorBelawan->id,
            ],
            [
                'location_id' => $locSingapore->id,
                'status' => 'IN_TRANSIT',
                'event_time' => Carbon::parse('2026-11-06 17:45:00'),
                'latitude' => 1.2644,
                'longitude' => 103.8220,
                'description' => 'Arrived PSA Singapore Transshipment Hub. Transferred to mother vessel Maersk Mc-Kinney Moller heading to Rotterdam.',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($events1 as $evt) {
            TrackingEvent::firstOrCreate(
                [
                    'shipment_id' => $shipment1->id,
                    'status' => $evt['status'],
                    'event_time' => $evt['event_time'],
                ],
                $evt
            );
        }

        // Shipment 2: Highland Fresh Produce (Takengon -> Belawan -> Singapore, DELIVERED)
        $shipment2 = Shipment::firstOrCreate(
            ['tracking_number' => 'AGLN-2026-GY002'],
            [
                'customer_id' => $customerSingapore->id,
                'carrier_id' => $carrierSamudera->id,
                'origin_id' => $locTakengon->id,
                'destination_id' => $locSingapore->id,
                'cargo_type' => 'Fresh Gayo Highland Butter Avocado & Premium Red Chili',
                'weight_kg' => 4500.00,
                'volume_cbm' => 12.50,
                'expected_departure' => Carbon::parse('2026-11-04 07:00:00'),
                'expected_arrival' => Carbon::parse('2026-11-08 16:00:00'),
                'estimated_arrival' => Carbon::parse('2026-11-08 14:15:00'),
                'status' => 'DELIVERED',
                'is_delayed' => false,
                'delay_duration_hours' => 0,
                'delay_severity' => 'NONE',
                'delay_reason' => null,
                'current_location_id' => $locSingapore->id,
            ]
        );

        ShipmentItem::firstOrCreate(
            ['shipment_id' => $shipment2->id, 'item_name' => 'Takengon Butter Avocado (Alpukat Mentega)'],
            [
                'quantity' => 150,
                'weight_kg' => 3000.00,
                'package_type' => 'Ventilated Agri-Crate 20kg',
                'description' => 'Cold-stored premium highland avocado from Bebesen, Takengon.',
            ]
        );
        ShipmentItem::firstOrCreate(
            ['shipment_id' => $shipment2->id, 'item_name' => 'Highland Bird\'s Eye Red Chili (Cabai Rawit)'],
            [
                'quantity' => 150,
                'weight_kg' => 1500.00,
                'package_type' => 'Ventilated Agri-Crate 10kg',
                'description' => 'Fresh spicy mountain chili, graded A for Singapore wholesale distribution.',
            ]
        );

        $events2 = [
            [
                'location_id' => $locTakengon->id,
                'status' => 'PICKED_UP',
                'event_time' => Carbon::parse('2026-11-04 07:00:00'),
                'latitude' => 4.6293,
                'longitude' => 96.8458,
                'description' => 'Refrigerated truck departed Takengon with cold-chain monitoring active.',
                'created_by' => $operatorGayo->id,
            ],
            [
                'location_id' => $locBelawan->id,
                'status' => 'IN_TRANSIT',
                'event_time' => Carbon::parse('2026-11-05 06:30:00'),
                'latitude' => 3.7844,
                'longitude' => 98.6833,
                'description' => 'Loaded onto fast express feeder vessel to Singapore Jurong Port.',
                'created_by' => $operatorBelawan->id,
            ],
            [
                'location_id' => $locSingapore->id,
                'status' => 'DELIVERED',
                'event_time' => Carbon::parse('2026-11-08 14:15:00'),
                'latitude' => 1.2644,
                'longitude' => 103.8220,
                'description' => 'Consignment safely delivered and accepted at SingaAgro Jurong Warehouse. Freshness verified.',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($events2 as $evt) {
            TrackingEvent::firstOrCreate(
                [
                    'shipment_id' => $shipment2->id,
                    'status' => $evt['status'],
                    'event_time' => $evt['event_time'],
                ],
                $evt
            );
        }

        // Shipment 3: Delayed Shipment with Exception (Weather Alert - Landslide Warning)
        $shipment3 = Shipment::firstOrCreate(
            ['tracking_number' => 'AGLN-2026-GY003'],
            [
                'customer_id' => $customerKoperasi->id,
                'carrier_id' => $carrierGaruda->id,
                'origin_id' => $locTakengon->id,
                'destination_id' => $locRotterdam->id,
                'cargo_type' => 'Micro-Lot Peaberry Gayo Green Coffee (Air Freight Sample)',
                'weight_kg' => 350.00,
                'volume_cbm' => 1.20,
                'expected_departure' => Carbon::parse('2026-11-09 09:00:00'),
                'expected_arrival' => Carbon::parse('2026-11-13 10:00:00'),
                'estimated_arrival' => Carbon::parse('2026-11-14 04:00:00'),
                'status' => 'IN_TRANSIT',
                'is_delayed' => true,
                'delay_duration_hours' => 18,
                'delay_severity' => 'HIGH',
                'delay_reason' => 'Extreme highland rainfall & landslide alert on Takengon-Bireuen mountain route (OpenWeather 85mm)',
                'current_location_id' => $locBireuen->id,
            ]
        );

        ShipmentItem::firstOrCreate(
            ['shipment_id' => $shipment3->id, 'item_name' => 'Gayo Rare Peaberry (Kopi Lanang) Microlot'],
            [
                'quantity' => 7,
                'weight_kg' => 350.00,
                'package_type' => 'Vacuum Sealed Carton 50kg',
                'description' => 'High-elevation single-origin peaberry samples for European Cupping Competition 2026.',
            ]
        );

        TrackingEvent::firstOrCreate(
            [
                'shipment_id' => $shipment3->id,
                'status' => 'PICKED_UP',
                'event_time' => Carbon::parse('2026-11-09 09:00:00'),
            ],
            [
                'location_id' => $locTakengon->id,
                'latitude' => 4.6293,
                'longitude' => 96.8458,
                'description' => 'Specialty cargo dispatched from Takengon central depot under heavy cloud cover.',
                'created_by' => $operatorGayo->id,
            ]
        );

        TrackingEvent::firstOrCreate(
            [
                'shipment_id' => $shipment3->id,
                'status' => 'IN_TRANSIT',
                'event_time' => Carbon::parse('2026-11-10 14:00:00'),
            ],
            [
                'location_id' => $locBireuen->id,
                'latitude' => 5.2045,
                'longitude' => 96.7009,
                'description' => 'Vehicle held safely at Bireuen Transit Station due to BPBD landslide road closure at Km 48.',
                'created_by' => $operatorGayo->id,
            ]
        );

        // Weather Exception for Shipment 3
        ShipmentException::firstOrCreate(
            ['shipment_id' => $shipment3->id, 'exception_type' => 'WEATHER_DELAY'],
            [
                'severity' => 'HIGH',
                'status' => 'OPEN',
                'description' => 'OpenWeather API trigger: Heavy rainstorm (85mm precipitation, wind 42 km/h) in Gayo mountain pass. Landslide risk confirmed by Aceh Tengah disaster agency. Estimated delay 18 hours.',
                'detected_at' => Carbon::parse('2026-11-10 13:30:00'),
                'resolved_at' => null,
                'resolution_notes' => 'AgriLian convoy waiting in safe zone; cargo integrity 100% secured with hermetic seals.',
                'reported_by' => $operatorGayo->id,
            ]
        );

        // Notifications
        Notification::firstOrCreate(
            ['title' => 'Highland Weather Alert: Shipment AGLN-2026-GY003 Delayed'],
            [
                'user_id' => $admin->id,
                'message' => 'Extreme rainfall detected on mountain corridor Takengon-Bireuen. Delay duration: +18 hours.',
                'type' => 'WEATHER_DELAY',
                'is_read' => false,
            ]
        );

        Notification::firstOrCreate(
            ['title' => 'Vessel Transfer Complete in Singapore (AGLN-2026-GY001)'],
            [
                'user_id' => $customerAmsterdam->id,
                'message' => 'Your Arabica Gayo container was successfully transferred to mother vessel Maersk. ETA Rotterdam on schedule.',
                'type' => 'STATUS_CHANGE',
                'is_read' => false,
            ]
        );

        // Audit Logs
        AuditLog::firstOrCreate(
            ['action' => 'TRIGGER_EXCEPTION', 'entity_id' => $shipment3->id],
            [
                'user_id' => $operatorGayo->id,
                'entity_type' => 'Shipment',
                'old_values' => ['is_delayed' => false, 'status' => 'IN_TRANSIT'],
                'new_values' => ['is_delayed' => true, 'delay_severity' => 'HIGH', 'delay_duration_hours' => 18],
                'ip_address' => '127.0.0.1',
            ]
        );
    }
}
