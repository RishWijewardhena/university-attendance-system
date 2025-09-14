<?php
namespace App\Models;

use CodeIgniter\Model;

class VenueModel extends Model
{
    protected $table = 'venues';
    protected $primaryKey = 'venue_id';
    protected $allowedFields = ['venue'];
}
