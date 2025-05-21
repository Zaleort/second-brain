package com.zaleort.second_brain.Memories.Domain.Memory

data class MemoryTag(
    val id: String,
    val name: String,
    val color: String? = null,
) {
    override fun toString(): String {
        return name
    }
}