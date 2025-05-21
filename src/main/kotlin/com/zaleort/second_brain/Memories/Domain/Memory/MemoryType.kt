package com.zaleort.second_brain.Memories.Domain.Memory

import com.zaleort.second_brain.Memories.Domain.Memory.Exceptions.InvalidMemoryTypeException

data class MemoryType(val value: Int) {
    init {
        if (value != LINK && value != TEXT) {
            throw InvalidMemoryTypeException("Invalid memory type: $value")
        }
    }

    override fun toString(): String {
        return when (value) {
            LINK -> "link"
            TEXT -> "text"
            else -> throw InvalidMemoryTypeException("Invalid memory type: $value")
        }
    }

    companion object {
        const val LINK = 1
        const val TEXT = 2

        fun link(): MemoryType {
            return MemoryType(LINK)
        }

        fun text(): MemoryType {
            return MemoryType(TEXT)
        }
    }
}