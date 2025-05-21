package com.zaleort.second_brain.Shared.Domain.Uuid
import java.util.UUID

open class Uuid(
    var value: String,
) {
    init {
        if (!isValid(value)) {
            throw InvalidUuidException("Invalid UUID: $value")
        }
    }

    fun toUUID(): UUID {
        return UUID.fromString(value)
    }

    override fun toString(): String {
        return value
    }

    override fun equals(other: Any?): Boolean {
        return this === other
                || (other is Uuid && value == other.value && this::class == other::class)
    }

    override fun hashCode(): Int {
        return value.hashCode()
    }

    companion object {
        fun random(): String {
            return UUID.randomUUID().toString()
        }

        fun isValid(value: String): Boolean {
            return try {
                UUID.fromString(value)
                true
            } catch (e: IllegalArgumentException) {
                false
            }
        }
    }
}
