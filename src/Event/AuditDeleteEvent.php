<?php

namespace AuditStash\Event;

use Datetime;

/**
 * Represents an audit log event for a newly deleted record.
 */
class AuditDeleteEvent extends BaseEvent
{
    use BaseEventTrait;
    use SerializableEventTrait {
        basicSerialize as public jsonSerialize;
    }

    /**
     * Construnctor.
     *
     * @param string $transactionId The global transaction id
     * @param mixed $id The primary key record that got deleted
     * @param string $source The name of the source (table) where the record was deleted
     * @param null $parentSource The name of the source (table) that triggered this change
     * @param array $original The original values the entity had before it got changed
     * @param string|null $displayValue The displa field's value
     */
    public function __construct(string $transactionId, $id, $source, ?string $displayValue, $parentSource = null, $original = [])
    {
        parent::__construct($transactionId, $id, $source, [], $original, $displayValue);
    }

    /**
     * Returns the name of this event type.
     *
     * @return string
     */
    public function getEventType(): string
    {
        return 'delete';
    }

    public function __serialize(): array
    {
        return [
            'transactionId' => $this->transactionId,
            'id' => $this->id,
            'source' => $this->source,
            'changed' => $this->changed,
            'original' => $this->original,
            'displayValue' => $this->displayValue,
            'timestamp' => $this->timestamp,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->transactionId = $data['transactionId'];
        $this->id = $data['id'];
        $this->source = $data['source'];
        $this->changed = $data['changed'];
        $this->original = $data['original'];
        $this->displayValue = $data['displayValue'];
        $this->timestamp = $data['timestamp'];
    }
}
