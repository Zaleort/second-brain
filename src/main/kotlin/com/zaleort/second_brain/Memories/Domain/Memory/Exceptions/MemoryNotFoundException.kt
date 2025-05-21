package com.zaleort.second_brain.Memories.Domain.Memory.Exceptions

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class MemoryNotFoundException(
    message: String = "Memory not found",
    status: Int = 404,
    code: String? = "MEMORY_NOT_FOUND",
) : SecondBrainError(
    message,
    status,
    code,
) {
}