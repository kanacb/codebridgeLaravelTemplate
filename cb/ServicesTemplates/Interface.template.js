export=`
<?php

namespace App\Interfaces;

interface ~cd-service-name~RepositoryInterface 
{
    public function getAll~cd-service-name~();
    public function get~cd-service-name~ById($~cd-service-name~Id);
    public function delete~cd-service-name~($~cd-service-name~Id);
    public function create~cd-service-name~(array $~cd-service-name~Details);
    public function update~cd-service-name~($~cd-service-name~Id, array $newDetails);
    public function getFulfilled~cd-service-name~();
}


`