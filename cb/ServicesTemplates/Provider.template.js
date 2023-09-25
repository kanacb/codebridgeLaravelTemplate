export=`

use App\Interfaces\~cb-service-name~RepositoryInterface;
use App\Repositories\~cb-service-name~Repository;

public function register() 
{
    $this->app->bind(~cb-service-name~RepositoryInterface::class, ~cb-service-name~Repository::class);
 }




`