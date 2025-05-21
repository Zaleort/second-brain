package com.zaleort.second_brain.Memories.Domain.Memory

data class MemoryContent(
    val value: String,
) {
    override fun toString(): String {
        return value
    }
}