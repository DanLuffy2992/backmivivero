<?php

// app/Models/Planta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    use HasFactory;

    protected $fillable = [
        'SKU',
        'nombre',
        'tipo_planta',
        'descripcion',
        'foto_path',
        'id_categoria',
        'cuidados',
    ];

    /**
     * Almacenar la imagen de la planta.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @return string
     */
    public function storeImage($image)
    {
        $imageName = $this->SKU . '.' . $image->getClientOriginalExtension();

        $imagePath = 'plant_images/' . $imageName;

        // Almacenar la imagen en la carpeta storage/app/public/plant_images
        \Intervention\Image\Facades\Image::make($image)->fit(300, 300)->save(storage_path('app/public/' . $imagePath));

        // Guardar la ruta de la imagen en la base de datos
        $this->foto_path = $imagePath;
        $this->save();

        return $imagePath;
    }

    /**
     * Obtener la URL completa de la imagen.
     *
     * @return string|null
     */
    public function getImageUrl()
    {
        if ($this->foto_path) {
            return asset('storage/' . $this->foto_path);
        }

        return null;
    }

    // Relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
