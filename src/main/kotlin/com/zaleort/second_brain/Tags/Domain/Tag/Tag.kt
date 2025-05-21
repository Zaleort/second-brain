package com.zaleort.second_brain.Tags.Domain.Tag

import com.zaleort.second_brain.Users.Domain.User.UserId

class Tag private constructor(
    val id: TagId,
    val userId: UserId,
    var name: TagName,
    var color: TagColor? = null,
) {
    fun update(name: TagName, color: TagColor?) {
        this.name = name
        this.color = color
    }

    companion object {
        fun create(
            id: TagId,
            userId: UserId,
            name: TagName,
            color: TagColor? = null,
        ): Tag {
            return Tag(id, userId, name, color)
        }

        fun fromPrimitives(
            id: String,
            userId: String,
            name: String,
            color: String? = null,
        ): Tag {
            return Tag(
                id = TagId(id),
                userId = UserId(userId),
                name = TagName(name),
                color = color?.let { TagColor(it) },
            )
        }
    }
}