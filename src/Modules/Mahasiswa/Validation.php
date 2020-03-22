<?php namespace Wongpinter\Feeder\Modules\Mahasiswa;

/**
 * Created By: Sugeng
 * Date: 25/11/19
 * Time: 10.17
 */
class Validation
{

    public function validate($input, $rules)
    {
        foreach ($this->parse($input, $rules) as $field => $validation) {
            foreach ($validation as $name => $data) {
                dump($name, $data);
            }
        }
    }

    function parse($input, $rules)
    {
        $result = [];

        foreach ($rules as $field => $rule) {
            $value_input = $input[$field];

            $result[$field] = $this->parseRules($rule, $value_input);
        }

        return $result;
    }

    /**
     * @param $rule
     * @param $value_input
     * @return array
     */
    private function parseRules($rule, $value_input): array
    {
        $result = [];
        $the_rules = explode('|', $rule);

        foreach ($the_rules as $the_rule) {
            list($rule_name, $option) = array_pad(explode(':', $the_rule), 2, null);

            $result[$rule_name] = [
                "value"  => $value_input,
                "option" => $option
            ];
        }

        return $result;
    }
}
