<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permissions', // سنخزن الأذونات كسلسلة نصية
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    
    // يمكن إضافة دالة لتحويل الأذونات إلى مصفوفة هنا إذا لزم الأمر
    public function getPermissionsArray(): array
    {
        return explode(',', $this->permissions); // تحويل السلسلة إلى مصفوفة
    }
}
