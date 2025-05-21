package com.zaleort.second_brain.Memories.Application.UseCases.CreateMemory

import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Domain.Memory.Memory
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryContent
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryId
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryTag
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryTitle
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryType
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import com.zaleort.second_brain.Shared.Domain.Uuid.Uuid
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import com.zaleort.second_brain.Users.Domain.User.UserId
import org.springframework.stereotype.Service

@Service
class CreateMemoryHandler(
    val repository: MemoryRepositoryInterface,
    val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: CreateMemoryCommand): MemoryDTO {
        val tags = command.tags.mapNotNull { tagRepository.findById(TagId(it)) }
            .map { MemoryTag(it.id.value, it.name.value, it.color?.value) }

        val memory = Memory.create(
            id = MemoryId(Uuid.random()),
            userId = UserId(command.userId),
            title = MemoryTitle(command.title),
            content = MemoryContent(command.content),
            type = MemoryType(command.type),
            tags = tags,
        )

        this.repository.save(memory)

        return MemoryDTO.fromMemory(memory)
    }
}