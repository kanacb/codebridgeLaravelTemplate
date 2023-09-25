export=`

public function definition() 
{
    return [
        '~cd-service-name~'       => $this->faker->sentences(4, true),
        '~cd-service-name~'       => $this->faker->name(),
        'is_fulfilled' => $this->faker->boolean(),
    ];
}

`
