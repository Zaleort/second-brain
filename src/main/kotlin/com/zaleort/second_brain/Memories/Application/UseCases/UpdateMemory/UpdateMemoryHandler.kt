package com.zaleort.second_brain.Memories.Application.UseCases.UpdateMemory

import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Domain.Memory.Exceptions.MemoryNotFoundException
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryContent
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryId
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryTag
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryTitle
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryType
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import com.zaleort.second_brain.Tags.Domain.Tag.TagId
import com.zaleort.second_brain.Tags.Domain.Tag.TagRepositoryInterface
import org.springframework.stereotype.Service

@Service
class UpdateMemoryHandler(
    val repository: MemoryRepositoryInterface,
    val tagRepository: TagRepositoryInterface,
) {
    fun execute(command: UpdateMemoryCommand): MemoryDTO {
        val memory = this.repository.findById(MemoryId(command.id))
            ?: throw MemoryNotFoundException("Memory not found: ${command.id}")

        if (memory.userId.value != command.userId) {
            throw MemoryNotFoundException("Memory not found: ${command.id}")
        }

        val tags = command.tags.mapNotNull { tagRepository.findById(TagId(it)) }
            .map { MemoryTag(it.id.value, it.name.value, it.color?.value) }

        memory.update(
            title = MemoryTitle(command.title),
            content = MemoryContent(command.content),
            type = MemoryType(command.type),
            tags = tags,
        )

        this.repository.save(memory)
        return MemoryDTO.fromMemory(memory)
    }
}