package com.zaleort.second_brain.Tags.Application.UseCases

import com.zaleort.second_brain.Tags.Domain.Tag.Tag

data class TagDTO(
    val id: String,
    val name: String,
    val color: String?,
) {
    companion object {
        fun fromTag(tag: Tag): TagDTO {
            return TagDTO(
                id = tag.id.value,
                name = tag.name.value,
                color = tag.color?.value,
            )
        }
    }
}