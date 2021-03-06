<?php

namespace Mnabialek\LaravelSqlLogger\Objects;

use Mnabialek\LaravelSqlLogger\Objects\Concerns\ReplacesBindings;

class SqlQuery
{
    use ReplacesBindings;

    /**
     * @var int
     */
    private $number;

    /**
     * @var string
     */
    private $sql;

    /**
     * @var array
     */
    private $bindings;

    /**
     * @var float
     */
    private $time;

    /**
     * SqlQuery constructor.
     *
     * @param int $number
     * @param string $sql
     * @param array $bindings
     * @param float $time
     */
    public function __construct($number, $sql, array $bindings, $time)
    {
        $this->number = $number;
        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->time = $time;
    }

    /**
     * Get number of query.
     * 
     * @return int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * Get raw SQL (without bindings).
     * 
     * @return string
     */
    public function raw()
    {
        return $this->sql;
    }

    /**
     * Get bindings.
     * 
     * @return array
     */
    public function bindings()
    {
        return $this->bindings;
    }

    /**
     * Get time.
     * 
     * @return float
     */
    public function time()
    {
        return $this->time;
    }

    /**
     * Get full query with values from bindings inserted.
     *
     * @return string
     */
    public function get()
    {
        return $this->removeNewLines($this->replaceBindings($this->sql, $this->bindings));
    }

    /**
     * Remove new lines from SQL to keep it in single line if possible.
     *
     * @param string $sql
     *
     * @return string
     */
    protected function removeNewLines($sql)
    {
        return preg_replace($this->wrapRegex($this->notInsideQuotes('\v', false)), ' ', $sql);
    }
}
