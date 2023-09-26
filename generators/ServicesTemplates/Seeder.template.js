module.exports = `

use App\Models\~cd-fakerName~;

public function run() 
{
    ~cd-fakerName~::factory()->times(~cd-seedTime~)->create();
}`;
