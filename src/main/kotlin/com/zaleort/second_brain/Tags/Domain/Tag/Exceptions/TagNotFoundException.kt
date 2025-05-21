package com.zaleort.second_brain.Tags.Domain.Tag.Exceptions

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class TagNotFoundException(
    message: String = "Tag not found",
    status: Int = 404,
    code: String = "TAG_NOT_FOUND",
) : SecondBrainError(
    message,
    status,
    code,
)