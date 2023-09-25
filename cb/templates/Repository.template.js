export = `
<?php

namespace App\Repositories;

use App\Interfaces\~cb-service-name~RepositoryInterface;
use App\Models\~cb-service-name~;

class ~cb-service-name~Repository implements ~cb-service-name~RepositoryInterface 
{
    public function getAll~cb-service-name~s() 
    {
        return ~cb-service-name~::all();
    }

    public function get~cb-service-name~ById($~cb-service-name~Id) 
    {
        return ~cb-service-name~::findOrFail($~cb-service-name~Id);
    }

    public function delete~cb-service-name~($~cb-service-name~Id) 
    {
        ~cb-service-name~::destroy($~cb-service-name~Id);
    }

    public function create~cb-service-name~(array $~cb-service-name~Details) 
    {
        return ~cb-service-name~::create($~cb-service-name~Details);
    }

    public function update~cb-service-name~($~cb-service-name~Id, array $newDetails) 
    {
        return ~cb-service-name~::whereId($~cb-service-name~Id)->update($newDetails);
    }

    public function getFulfilled~cb-service-name~s() 
    {
        return ~cb-service-name~::where('is_fulfilled', true);
    }
}



`
