<?php


namespace App\Core\Helpers;

use Illuminate\Support\Str;

/**
 * object 를 array 로 변경할 수 있도록 만드는 헬퍼 trait
 * - private/protected/public 에 상관없이 key => value, associative array 로 변환
 * - 단, key 는 snake_case 형태로 자동 변환
 * - Eloquent 모델처럼 jsonSerialize and toArray 가 이미 정의된 object 에 이 trait 을
 *   사용하면 기존 behavior 를 override 하게 되므로, side-effect 가 발생하지않게 사용하려면
 *   가급적 Dto 및 Value Object 와 같이, 추가로 생성한 object 에서만 사용.
 *
 * Trait JsonSerializableTrait
 * @package App\Core\Helpers
 */
trait JsonSerializableTrait
{
    public function toArray(): array
    {
        $arr  = get_object_vars($this);
        $data = [];
        array_walk($arr, function ($v, $k) use (&$data) {
            if ($v instanceof \JsonSerializable) {
                $v = $v->jsonSerialize();
            }
            $data[Str::snake($k)] = $v;
        });

        return $data;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
