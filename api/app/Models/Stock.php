<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property ?float $price
 * @property ?float $open
 * @property ?float $high
 * @property ?float $low
 * @property ?float $close
 * @property ?int $user_id
 */
class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'symbol',
        'price',
        'open',
        'high',
        'low',
        'close',
        'date',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'date' => 'date:Y-m-d',
        ];
    }

    /**
     * Get the ID of the stock.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the symbol of the stock.
     *
     * @return ?string
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * Set the symbol of the stock.
     *
     * @param string $symbol
     * @return void
     */
    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    /**
     * Get the symbol of the stock.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the symbol of the stock.
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the price of the stock.
     *
     * @return ?float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Set the price of the stock.
     *
     * @param float $price
     * @return void
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * Get the open value of the stock.
     *
     * @return ?float
     */
    public function getOpen(): ?float
    {
        return $this->open;
    }

    /**
     * Set the open value of the stock.
     *
     * @param float $open
     * @return void
     */
    public function setOpen(float $open): void
    {
        $this->open = $open;
    }

    /**
     * Get the high value of the stock.
     *
     * @return ?float
     */
    public function getHigh(): ?float
    {
        return $this->high;
    }

    /**
     * Set the high value of the stock.
     *
     * @param float $high
     * @return void
     */
    public function setHigh(float $high): void
    {
        $this->high = $high;
    }

    /**
     * Get the low value of the stock.
     *
     * @return ?float
     */
    public function getLow(): ?float
    {
        return $this->low;
    }

    /**
     * Set the low value of the stock.
     *
     * @param float $low
     * @return void
     */
    public function setLow(float $low): void
    {
        $this->low = $low;
    }

    /**
     * Get the close value of the stock.
     *
     * @return ?float
     */
    public function getClose(): ?float
    {
        return $this->close;
    }

    /**
     * Set the close value of the stock.
     *
     * @param float $close
     * @return void
     */
    public function setClose(float $close): void
    {
        $this->close = $close;
    }

    /**
     * Get the user ID associated with the stock.
     *
     * @return ?int
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * Set the user ID associated with the stock.
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user_id = $user->getId();
    }

    /**
     * @return ?Carbon
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    /**
     * @return ?Carbon
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    /**
     * @return ?Carbon
     */
    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    /**
     * @param $date
     * @return void
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * Get the user that owns the stock.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
