package com.zaleort.second_brain.Shared.Domain.Email

open class Email(
    open val value: String,
) {
    init {
        if (!isValid(value)) {
            throw InvalidEmailException("Invalid email: $value")
        }
    }

    override fun toString(): String {
        return value
    }

    override fun equals(other: Any?): Boolean {
        return this === other
                || (other is Email && value == other.value && this::class == other::class)
    }

    override fun hashCode(): Int {
        return value.hashCode()
    }

    companion object {
        fun isValid(value: String): Boolean {
            return value.matches(
                Regex(
                    "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$"
                )
            )
        }
    }
}
