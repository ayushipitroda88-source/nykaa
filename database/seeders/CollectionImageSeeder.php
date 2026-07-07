<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Collection;

class CollectionImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dir = public_path('uploads/collections');

        if (!File::exists($dir)) {
            $this->command->info('Directory not found: ' . $dir);
            return;
        }

        $files = collect(File::files($dir))->map->getFilename();

        foreach ($files as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);

            // Try direct slug match
            $collection = Collection::where('slug', $name)->first();

            if (!$collection) {
                // Try matching by slugified filename
                $slug = Str::slug($name);
                $collection = Collection::where('slug', $slug)->first();
            }

            if (!$collection) {
                // Try matching by name (case-insensitive)
                $collection = Collection::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
            }

            if ($collection) {
                $collection->image = $file;
                $collection->save();
                $this->command->info('Updated collection id='.$collection->id.' image='.$file);
            } else {
                $this->command->info('No collection found for file: '.$file);
            }
        }
    }
}
