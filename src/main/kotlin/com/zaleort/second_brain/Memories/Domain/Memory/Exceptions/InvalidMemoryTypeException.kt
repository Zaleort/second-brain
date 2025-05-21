package com.zaleort.second_brain.Memories.Domain.Memory.Exceptions

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class InvalidMemoryTypeException(
    message: String = "Invalid memory type.",
    status: Int = 400,
    code: String = "invalid_memory_type",
) : SecondBrainError(message, status, code)