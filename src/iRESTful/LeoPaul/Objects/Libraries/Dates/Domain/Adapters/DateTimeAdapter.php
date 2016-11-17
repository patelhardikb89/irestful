<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters;

interface DateTimeAdapter {
    public function fromTimestampToDateTime($timestamp);
}
