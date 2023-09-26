module.exports = `
use App\Listeners\LogVerifiedUser;
use Illuminate\Auth\Events\Verified;

protected $listen=[



    Verified::class => [
        LogVerifiedUser::class,
    ],

]


`