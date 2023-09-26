module.exports = `
public function definition() 
{
    return [
        '~cd-fakerName~'=> $this->faker->'~cd-fakerType~'('~cd-fakerCondition1~','~cb-fakerCondition2~'),
    ];
}`;
