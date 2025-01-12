<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('table_specialties')->insert([
            ['name' => 'Cardiology'],
            ['name' => 'Neurology'],
            ['name' => 'Pediatrics'],
            ['name' => 'Oncology'],
            ['name' => 'Dermatology'],
            ['name' => 'Gynecology'],
            ['name' => 'Urology'],
            ['name' => 'Ophthalmology'],
            ['name' => 'Orthopedics'],
            ['name' => 'Psychiatry'],
            ['name' => 'Radiology'],
            ['name' => 'Surgery'],
            ['name' => 'Anesthesiology'],
            ['name' => 'Endocrinology'],
            ['name' => 'Gastroenterology'],
            ['name' => 'Hematology'],
            ['name' => 'Infectious Diseases'],
            ['name' => 'Nephrology'],
            ['name' => 'Pulmonology'],
            ['name' => 'Rheumatology'],
            ['name' => 'Allergy and Immunology'],
            ['name' => 'Critical Care Medicine'],
            ['name' => 'Emergency Medicine'],
            ['name' => 'Family Medicine'],
            ['name' => 'Internal Medicine'],
            ['name' => 'Physical Medicine and Rehabilitation'],
            ['name' => 'Preventive Medicine'],
            ['name' => 'Sports Medicine'],
            ['name' => 'Occupational Medicine'],
            ['name' => 'Pain Medicine'],
            ['name' => 'Sleep Medicine'],
            ['name' => 'Clinical Neurophysiology'],
            ['name' => 'Geriatric Medicine'],
            ['name' => 'Hospice and Palliative Medicine'],
            ['name' => 'Medical Toxicology'],
            ['name' => 'Pediatric Emergency Medicine'],
            ['name' => 'Undersea and Hyperbaric Medicine'],
            ['name' => 'Addiction Medicine'],
            ['name' => 'Developmental-Behavioral Pediatrics'],
            ['name' => 'Neonatal-Perinatal Medicine'],
            ['name' => 'Pediatric Cardiology'],
            ['name' => 'Pediatric Critical Care Medicine'],
            ['name' => 'Pediatric Endocrinology'],
            ['name' => 'Pediatric Gastroenterology'],
            ['name' => 'Pediatric Hematology-Oncology'],
            ['name' => 'Pediatric Infectious Diseases'],
            ['name' => 'Pediatric Nephrology'],
            ['name' => 'Pediatric Pulmonology'],
        ]);
    }
}