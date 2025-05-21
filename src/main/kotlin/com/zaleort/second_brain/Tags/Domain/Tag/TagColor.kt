package com.zaleort.second_brain.Tags.Domain.Tag

data class TagColor(
    val value: String,
) {
    init {
        if (value.isBlank()) {
            throw IllegalArgumentException("Tag color cannot be blank")
        }
    }

    override fun toString(): String {
        return value
    }
}