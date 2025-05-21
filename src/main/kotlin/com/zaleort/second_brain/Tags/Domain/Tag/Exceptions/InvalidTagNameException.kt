package com.zaleort.second_brain.Tags.Domain.Tag.Exceptions

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class InvalidTagNameException(
    message: String = "Invalid tag name",
    status: Int = 400,
    code: String = "INVALID_TAG_NAME",
) : SecondBrainError(
    message,
    status,
    code,
)