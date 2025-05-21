package com.zaleort.second_brain.Tags.Domain.Tag

import com.zaleort.second_brain.Tags.Domain.Tag.Exceptions.InvalidTagNameException

data class TagName(val value: String) {
    init {
        if (value.isBlank()) {
            throw InvalidTagNameException("Tag name cannot be empty")
        }

        if (value.length > 50) {
            throw InvalidTagNameException("Tag name cannot be longer than 50 characters")
        }
    }

    override fun toString(): String {
        return value
    }
}