<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'sex', 'department_id', 'rating',
    ];

    public function indicators() {
        return $this->hasMany('App\EmployeeIndicator');
    }

    /**
     * Этот метод формирует и отправляет запрос для массового обновления значений итогового рейтинга работников.
     *
     * @var array
     * @return array
     */

    public static function updateRatings(array $values) {
        $table = Employee::getModel()->getTable();

        $cases = [];
        $ids = [];
        $params = [];

        foreach ($values as $value) {
            $id = (int)$value['id'];
            $cases[] = "WHEN {$id} then ?";
            $params[] = $value['rating'];
            $ids[] = $id;
        }

        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        $params[] = now();
        try {
            \DB::update("UPDATE `{$table}` SET `rating` = CASE `id` {$cases} END, `updated_at` = ? WHERE `id` in ({$ids})", $params);
        }
        catch (\Exception $e) {
            return array( 'success' => false,
                'message' => $e->getMessage());
        }
        return array( 'success' => true);
    }
}

